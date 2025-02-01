<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DemoProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
// use App\Imports\ProductsImport;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::query();
            $products = $products->when(
                $request->q == 'low_stocked',
                fn($query) => $query->where('quantity', '<=', 5)
            );
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('image', fn($data) => '<img src="' . absolutePath($data->image) . '" loading="lazy" alt="' . $data->name . '" class="img-thumb img-fluid" onerror="this.onerror=null; this.src=\'' . asset('assets/images/no-image.png') . '\';" height="80" width="60" />')
                ->editColumn('name', fn($data) => $data->name.'<br>'. $data->sku)
                ->addColumn(
                    'price',
                    fn($data) => $data->discounted_price .
                        ($data->price > $data->discounted_price
                            ? '<br><del>' . $data->price . '</del>'
                            : '')
                )
                ->editColumn('quantity', fn($data) => $data->quantity . ' ' . optional($data->unit)->short_name)
                ->editColumn('created_at', fn($data) => $data->created_at->format('d M, Y'))
                ->editColumn('status', fn($data) => $data->status
                    ? '<span class="badge bg-primary">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>')
                ->addColumn('action', function ($row) {
                    return view('admin.products.action', compact('row'));
                })
                ->rawColumns(['image', 'name', 'price', 'quantity', 'status', 'created_at', 'action'])
                ->toJson();
        }
        if ($request->wantsJson()) {
            $request->validate([
                'search' => 'required|string|max:255',
            ]);

            // Initialize the query
            $products = Product::query();

            // Apply filters based on the search term
            $products = $products->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('sku', $request->search);
            });
            // Get the results
            $products = $products->get();
            // Return the results as a JSON response
            return ProductResource::collection($products);
        }
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::whereStatus(true)->get();
        $categories = Category::whereStatus(true)->get();
        $units = Unit::all();
        return view('admin.products.create', compact('brands', 'categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);
        if ($request->hasFile("product_image")) {
            $filePath = $this->uploadImage($request->file('product_image'), 'media/products');
            $product->image = $filePath;
            $product->save();
        }


        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $product = Product::findOrFail($id);
        $brands = Brand::whereStatus(true)->get();
        $categories = Category::whereStatus(true)->get();
        $units = Unit::all();
        return view('admin.products.edit', compact('brands', 'categories', 'units', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);
        $oldImage = $product->image;
        $product->update($validated);
        if ($request->hasFile("product_image")) {
            $filePath = $this->uploadImage($request->file('product_image'), 'media/products');
            $product->image = $filePath;
            $product->save();
            if ($oldImage) {
                $this->deleteImage($oldImage);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('delete_brand'), 403);
        try {
            $product = Product::findOrFail($id);
            if ($product->image) {
                $this->deleteImage($product->image);
            }
            $product->delete();
            return true;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // public function import(Request $request)
    // {
    //     if ($request->query('download-demo')) {
    //         return Excel::download(new DemoProductsExport, 'demo_products.xlsx');
    //     }
    //     if ($request->isMethod('post') && $request->hasFile('file')) {
    //         Excel::import(new ProductsImport, $request->file('file'));
    //         return redirect()->back()->with('success', 'Products imported successfully.');
    //     }
    //     return view('admin.products.import');
    // }
}
