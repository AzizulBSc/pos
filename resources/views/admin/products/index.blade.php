@extends('layouts.master')
@section('title', 'Product')
@section('content')
<div class="page-heading">
  <x-page-title title="Product" subtitle="" pageTitle="Product" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      {{-- <div class="card-header"><h5 class="card-title"></h5></div> --}}
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.products.create')}}">Add Product</a>
        </div>

        <div class="table-responsive">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>CreatedAt</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- Basic Tables end -->
</div>
@endsection

@push('js')
<script>
  let datatable = $("#table").DataTable({
    responsive: true,
    serverSide: true,
    processing: true,
    ajax: {
      url: "{{ route('admin.products.index') }}",
      data: function(d) {
        d.q = new URLSearchParams(window.location.search).get("q"); // Get 'q' query parameter from URL
      }
    },
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false, // Prevent ordering
        searchable: false // Prevent searching
      },

      {
        data: 'image',
        name: 'image'
      },
      {
        data: 'name',
        name: 'name'
      },
      {
        data: 'price',
        name: 'price'
      },
      {
        data: 'quantity',
        name: 'quantity'
      },

      {
        data: 'created_at',
        name: 'created_at'
      },

      {
        data: 'status',
        name: 'status'
      },
      {
        data: 'action',
        name: 'action'
      },
    ],
  });
</script>
@endpush