@extends('layouts.master')
@section('title', 'Supplier Create')
@section('content')
<div class="page-heading">
  <x-page-title title="Supplier Create" subtitle="" pageTitle="Supplier Create" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.suppliers.index')}}">All Suppliers</a>
        </div>
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-label">Name<sup class="text-danger">*</sup></label>
                <input type="text" name="name" id="name" placeholder="Name"
                  class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone" class="form-label">Phone<sup class="text-danger">*</sup></label>
                <input type="text" name="phone" id="phone" placeholder="Phone"
                  class="form-control" value="{{ old('phone') }}" required>
                @error('phone')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" placeholder="Email"
                  class="form-control" value="{{ old('email') }}" required>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone" class="form-label">Address</label>
                <input type="text" name="address" id="address" placeholder="Address"
                  class="form-control" value="{{ old('address') }}">

                @error('address')
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