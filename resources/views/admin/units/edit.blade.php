@extends('layouts.master')
@section('title', 'Unit Create')
@section('content')
<div class="page-heading">
  <x-page-title title="Unit Create" subtitle="" pageTitle="Unit Create" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.units.index')}}">All Units</a>
        </div>
        <form action="{{ route('admin.units.update',$unit->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-label">Name<sup class="text-danger">*</sup></label>
                <input type="text" name="name" id="name" placeholder="Name"
                  class="form-control" value="{{ old('name',$unit->name) }}" required>

                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone" class="form-label">Short Name</label>
                <input type="text" name="short_name" id="short_name" placeholder="Description"
                  class="form-control" value="{{ old('short_name',$unit->short_name) }}">

                @error('short_name')
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