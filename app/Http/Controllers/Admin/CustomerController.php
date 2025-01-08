<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view_customers'), 403);
        if ($request->ajax()) {
            $customers = Customer::latest();
            return DataTables::of($customers)
                ->addIndexColumn()
                ->editColumn('name', fn($data) => $data->name)
                ->editColumn('phone', fn($data) => $data->phone)
                ->editColumn('address', fn($data) => $data->address)
                ->addColumn('action', function ($row) {
                    return view('admin.customers.action', compact('row'));
                })
                ->rawColumns(['name', 'phone', 'action'])
                ->toJson();
        }
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create_customer'), 403);
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('create_customer'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:customers,phone',
            'email' => 'nullable|unique:customers,email',
            'address' => 'nullable|string',
        ]);
        $customer = Customer::create($request->except('_token'));
        return to_route('admin.customers.index')->with('success', 'Customer created successfully!');
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
        abort_if(!auth()->user()->can('update_customer'), 403);
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->can('update_customer'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:customers,phone,' . $id,
            'email' => 'nullable|unique:customers,email,' . $id,
            'address' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->except('_token'));
        return to_route('admin.customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(!auth()->user()->can('delete_customer'), 403);
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            return true;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
