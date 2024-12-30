<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\Exception\ThrowUpException;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view_category'), 403);
        if ($request->ajax()) {
            $categories = Category::latest();
            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('image', function ($data) {
                    return '<img src="' . absolutePath($data->image) . '" alt="Category Image" loading="lazy" style="width:50px; height:auto;">';
                })
                ->editColumn('name', fn($data) => $data->name)
                ->addColumn('action', function ($row) {
                    return view('admin.categories.action', compact('row'));
                })
                ->rawColumns(['image', 'name', 'action'])
                ->toJson();
        }
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create_category'), 403);
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('create_category'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
        ]);
        $category = Category::create($request->except('category_image', '_token'));
        if ($request->hasFile("category_image")) {
            $filePath = $this->uploadImage($request->file('category_image'), 'media/categories');
            $category->image = $filePath;
            $category->save();
        }

        return to_route('admin.categories.index')->with('success', 'Category created successfully!');
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
        abort_if(!auth()->user()->can('update_category'), 403);
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->can('update_category'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->except('category_image', '_token'));

        if ($request->hasFile("category_image")) {
            if ($category->image) {
                $this->deleteImage($category->image);
            }
            $filePath = $this->uploadImage($request->file('category_image'), 'media/categories');
            $category->image = $filePath;
            $category->save();
        }

        return to_route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(!auth()->user()->can('delete_category'), 403);
        try {
            $category = Category::findOrFail($id);
            if ($category->image) {
                $this->deleteImage($category->image);
            }
            $category->delete();
            return true;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
