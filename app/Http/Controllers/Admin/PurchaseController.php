<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view_purchases'), 403);
        if ($request->ajax()) {
            $purchases = Purchase::with('supplier')->latest()->get();
            return DataTables::of($purchases)
                ->addIndexColumn()
                ->addColumn('supplier', fn($data) => $data->supplier->name)
                ->addColumn('id', function ($data) {
                    return '#' . $data->id;
                })
                ->addColumn('total', fn($data) => $data->grand_total)
                ->addColumn('created_at', fn($data) => \Carbon\Carbon::parse($data->date)->format('d M, Y')) // Using Carbon for formatting
                ->addColumn('action',  function ($row) {
                    return view('admin.purchase.action', compact('row'));
                })
                ->rawColumns(['supplier', 'id', 'total', 'created_at', 'action'])
                ->toJson();
        }
        return view('admin.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create_purchase'), 403);
        return view('admin.purchase.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('create_purchase'), 403);
        if ($request->wantsJson()) {
            // Step 1: Validate the request data
            $validatedData = $request->validate([
                'products' => 'required|array',
                'purchase_id' => 'nullable|integer',
                'date' => 'nullable|date',
                'supplierId' => 'required|exists:suppliers,id',
                'totals' => 'required|array',
                'totals.subTotal' => 'required|numeric',
                'totals.tax' => 'nullable|numeric',
                'totals.discount' => 'nullable|numeric',
                'totals.shipping' => 'nullable|numeric',
                'totals.grandTotal' => 'required|numeric',
            ]);

            if ($validatedData['purchase_id'] == null) {
                DB::beginTransaction();
                // Step 2: Create a new purchase record
                try {
                    $purchase = Purchase::create([
                        'supplier_id' => $validatedData['supplierId'],
                        'user_id' => auth()->id(),
                        'sub_total' => $validatedData['totals']['subTotal'],
                        'tax' => $validatedData['totals']['tax'],
                        'discount_value' => $validatedData['totals']['discount'],
                        'shipping' => $validatedData['totals']['shipping'],
                        'grand_total' => $validatedData['totals']['grandTotal'],
                        'date' => $validatedData['date'] ?? Carbon::now()->toDateString(),
                        'status' => 1,
                    ]);

                    // Step 3: Create purchase items
                    foreach ($validatedData['products'] as $product) {
                        $existingProduct = Product::findOrFail($product['id']);
                        PurchaseProduct::create([
                            'purchase_id' => $purchase->id,
                            'product_id' => $product['id'],
                            'purchase_price' => $product['purchase_price'],
                            'price' => $product['price'],
                            'quantity' => $product['qty'],
                        ]);

                        $existingProduct->increment('quantity', $product['qty']);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['error' => $e->getMessage()], 400);
                }
            } else {
                DB::beginTransaction();
                try {
                    $purchase = Purchase::findOrFail($validatedData['purchase_id']);
                    $purchase->update([
                        'supplier_id' => $validatedData['supplierId'],
                        'user_id' => auth()->id(),
                        'sub_total' => $validatedData['totals']['subTotal'],
                        'tax' => $validatedData['totals']['tax'],
                        'discount_value' => $validatedData['totals']['discount'],
                        'shipping' => $validatedData['totals']['shipping'],
                        'grand_total' => $validatedData['totals']['grandTotal'],
                        'date' => $validatedData['date'] ?? Carbon::now()->toDateString(),
                        'status' => 1,
                    ]);
                    // Step 3: Create purchase items
                    foreach ($validatedData['products'] as $product) {
                        $existingProduct = Product::findOrFail($product['id']);
                        PurchaseProduct::updateOrCreate(
                            [
                                'id' => $product['item_id'] ?? null
                            ],
                            [
                                'purchase_id' => $purchase->id,
                                'product_id' => $product['id'],
                                'purchase_price' => $product['purchase_price'],
                                'price' => $product['price'],
                                'quantity' => $product['qty'],
                            ]
                        );

                        $existingProduct->increment('quantity', $product['qty']);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['error' => $e->getMessage()], 400);
                }
            }
            // Step 4: Return a response
            return response()->json([
                'message' => 'Purchase saved successfully.',
                'purchase' => $purchase,
            ], 201);
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {

        abort_if(!auth()->user()->can('view_purchases'), 403);
        if ($request->wantsJson()) {
            $purchase = Purchase::with('items', 'supplier')->findOrFail($id);
            return $purchase;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        abort_if(!auth()->user()->can('update_purchase'), 403);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        abort_if(!auth()->user()->can('update_purchase'), 403);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        abort_if(!auth()->user()->can('delete_purchase'), 403);
        //
    }
    public function purchaseProducts(Request $request, $id)
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);
        return view('admin.purchase.products', compact('id', 'purchase'));
    }
}
