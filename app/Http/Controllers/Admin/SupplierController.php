<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view_suppliers'), 403);
        if ($request->ajax()) {
            $suppliers = Supplier::latest();
            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->editColumn('name', fn($data) => $data->name)
                ->editColumn('phone', fn($data) => $data->phone)
                ->editColumn('address', fn($data) => $data->address)
                ->addColumn('action', function ($row) {
                    return view('admin.suppliers.action', compact('row'));
                })
                ->rawColumns(['name', 'phone', 'action'])
                ->toJson();
        }
        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create_supplier'), 403);
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('create_supplier'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:suppliers,phone',
            'email' => 'nullable|unique:suppliers,email',
            'address' => 'nullable|string',
        ]);
        $supplier = Supplier::create($request->except('_token'));
        return to_route('admin.suppliers.index')->with('success', 'Supplier created successfully!');
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
        abort_if(!auth()->user()->can('update_supplier'), 403);
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->can('update_supplier'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:suppliers,phone,' . $id,
            'email' => 'nullable|unique:suppliers,email,' . $id,
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->except('_token'));
        return to_route('admin.suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(!auth()->user()->can('delete_supplier'), 403);
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();
            return true;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
