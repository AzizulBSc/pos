@extends('layouts.master')
@section('title', 'Brand Create')
@section('content')
<div class="page-heading">
  <x-page-title title="Brand Create" subtitle="" pageTitle="Brand Create" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.brands.index')}}">All Brands</a>
        </div>
        <form action="{{ route('admin.brands.update',$brand->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-label">Name<sup class="text-danger">*</sup></label>
                <input type="text" name="name" id="name" placeholder="Name"
                  class="form-control" value="{{ old('name',$brand->name) }}" required>

                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone" class="form-label">Description</label>
                <input type="text" name="description" id="description" placeholder="Description"
                  class="form-control" value="{{ old('description',$brand->description) }}">

                @error('description')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">Image</label>
                <input type="file" name="brand_image" id="brand_image" class="basic-filepond"
                  accept="image/*"
                  data-source="{{absolutePath($brand->image)}}">

                @error('brand_image')
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