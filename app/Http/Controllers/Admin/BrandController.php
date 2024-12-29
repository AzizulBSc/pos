<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\Exception\ThrowUpException;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::latest();
            return DataTables::of($brands)
                ->addIndexColumn()
                ->editColumn('image', function ($data) {
                    return '<img src="' . absolutePath($data->image) . '" alt="Brand Image" loading="lazy" style="width:50px; height:auto;">';
                })
                ->editColumn('name', fn($data) => $data->name)
                ->addColumn('action', function ($row) {
                    return view('admin.brands.action', compact('row'));
                })
                ->rawColumns(['image', 'name', 'action'])
                ->toJson();
        }
        return view('admin.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
        ]);
        $brand = Brand::create($request->except('brand_image', '_token'));
        if ($request->hasFile("brand_image")) {
            $filePath = $this->uploadImage($request->file('brand_image'), 'media/brands');
            $brand->image = $filePath;
            $brand->save();
        }

        return to_route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update($request->except('brand_image', '_token'));

        if ($request->hasFile("brand_image")) {
            if ($brand->image) {
                $this->deleteImage($brand->image);
            }
            $filePath = $this->uploadImage($request->file('brand_image'), 'media/brands');
            $brand->image = $filePath;
            $brand->save();
        }

        return to_route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            if ($brand->image) {
                $this->deleteImage($brand->image);
            }
            $brand->delete();
            return true;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
