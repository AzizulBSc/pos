@extends('layouts.master')
@section('title', 'Product Create')
@section('content')
<div class="page-heading">
  <x-page-title title="Product Create" subtitle="" pageTitle="Product Create" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.products.index')}}">All Products</a>
        </div>
        <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="row">
            <!-- Name -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-label">Name<sup class="text-danger">*</sup></label>
                <input type="text" name="name" id="name" placeholder="Name"
                  class="form-control" value="{{ old('name', $product->name ?? '') }}" required>

                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Slug -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="slug" class="form-label">Slug<sup class="text-danger">*</sup></label>
                <input type="text" name="slug" id="slug" placeholder="Slug"
                  class="form-control" value="{{ old('slug', $product->slug ?? '') }}" required>

                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- SKU -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="sku" class="form-label">SKU<sup class="text-danger">*</sup></label>
                <input type="text" name="sku" id="sku" placeholder="SKU"
                  class="form-control" value="{{ old('sku', $product->sku ?? '') }}" required>

                @error('sku')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Barcode -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="barcode" class="form-label">Barcode</label>
                <input type="text" name="barcode" id="barcode" placeholder="Barcode"
                  class="form-control" value="{{ old('barcode', $product->barcode ?? '') }}">

                @error('barcode')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" placeholder="Description"
                  class="form-control">{{ old('description', $product->description ?? '') }}</textarea>

                @error('description')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Category -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control select2">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                  @endforeach
                </select>

                @error('category_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Brand -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="brand_id" class="form-label">Brand</label>
                <select name="brand_id" id="brand_id" class="form-control select2">
                  <option value="">Select Brand</option>
                  @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                  </option>
                  @endforeach
                </select>

                @error('brand_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Unit -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="unit_id" class="form-label">Unit</label>
                <select name="unit_id" id="unit_id" class="form-control select2">
                  <option value="">Select Unit</option>
                  @foreach($units as $unit)
                  <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}
                  </option>
                  @endforeach
                </select>

                @error('unit_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Price -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="price" class="form-label">Price<sup class="text-danger">*</sup></label>
                <input type="number" name="price" id="price" placeholder="Price"
                  class="form-control" value="{{ old('price', $product->price ?? '') }}" required step="0.01">

                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Discount -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" name="discount" id="discount" placeholder="Discount"
                  class="form-control" value="{{ old('discount', $product->discount ?? '') }}" step="0.01">

                @error('discount')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Discount Type -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="discount_type" class="form-label">Discount Type</label>
                <select name="discount_type" id="discount_type" class="form-control">
                  <option value="fixed" {{ old('discount_type', $product->discount_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                  <option value="percentage" {{ old('discount_type', $product->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                </select>

                @error('discount_type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Purchase Price -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="purchase_price" class="form-label">Purchase Price<sup class="text-danger">*</sup></label>
                <input type="number" name="purchase_price" id="purchase_price" placeholder="Purchase Price"
                  class="form-control" value="{{ old('purchase_price', $product->purchase_price ?? '') }}" required step="0.01">

                @error('purchase_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Quantity -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="quantity" class="form-label">Quantity<sup class="text-danger">*</sup></label>
                <input type="number" name="quantity" id="quantity" placeholder="Quantity"
                  class="form-control" value="{{ old('quantity', $product->quantity ?? '') }}" required min="0">

                @error('quantity')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Expire Date -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="expire_date" class="form-label">Expire Date</label>
                <input type="date" name="expire_date" id="expire_date" placeholder="Expire Date"
                  class="form-control" value="{{ old('expire_date', $product->expire_date ?? '') }}">


                @error('expire_date')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Low Stock Threshold -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="low_stock_threshold" class="form-label">Low Stock Threshold</label>
                <input type="number" name="low_stock_threshold" id="low_stock_threshold" placeholder="Low Stock Threshold"
                  class="form-control" value="{{ old('low_stock_threshold',$product->low_stock_threshold ?? '') }}">

                @error('low_stock_threshold')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Status -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="status" class="form-label">Status<sup class="text-danger">*</sup></label>
                <select name="status" id="status" class="form-control">
                  <option value="1" {{ old('status',$product->status) == '1' ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('status',$product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>

                @error('status')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">Image</label>
                <input type="file" name="product_image" id="product_image" class="basic-filepond"
                  accept="image/*"
                  data-source="{{absolutePath($product->image)}}">

                @error('product_image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
          </div>
          <div class="col-12 text-end mt-2">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- Basic Tables end -->
</div>
@endsection

@push('js')
@endpush