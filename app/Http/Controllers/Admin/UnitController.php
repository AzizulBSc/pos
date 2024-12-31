<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view_units'), 403);
        if ($request->ajax()) {
            $units = Unit::latest();
            return DataTables::of($units)
                ->addIndexColumn()
                ->editColumn('name', fn($data) => $data->name)
                ->editColumn('short_name', fn($data) => $data->short_name)
                ->addColumn('action', function ($row) {
                    return view('admin.units.action', compact('row'));
                })
                ->rawColumns(['name', 'short_name','action'])
                ->toJson();
        }
        return view('admin.units.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create_unit'), 403);
        return view('admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('create_unit'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string',
            'status' => 'boolean',
        ]);
        $unit = Unit::create($request->except( '_token'));
        return to_route('admin.units.index')->with('success', 'Unit created successfully!');
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
        abort_if(!auth()->user()->can('update_unit'), 403);
        $unit = Unit::findOrFail($id);
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->can('update_unit'), 403);
        $validated = $request->validate([
             'name' => 'required|string|max:255',
            'short_name' => 'required|string',
            'status' => 'boolean',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update($request->except( '_token'));
        return to_route('admin.units.index')->with('success', 'Unit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(!auth()->user()->can('delete_unit'), 403);
        try {
            $unit = Unit::findOrFail($id);
            $unit->delete();
            return true;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
