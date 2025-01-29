@extends('layouts.master')
@section('title', 'Sale')
@section('content')
<div class="page-heading">
  <x-page-title title="Sale" subtitle="" pageTitle="Sale" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      {{-- <div class="card-header"><h5 class="card-title"></h5></div> --}}
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.cart.index')}}">Add Sale</a>
        </div>

        <div class="table-responsive">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Invoice</th>
                <th>Total</th>
                <th>Due</th>
                <th>CreatedAt</th>
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
    ajax: "{{ route('admin.sales.index') }}",
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false, // Prevent ordering
        searchable: false // Prevent searching
      },
      {
        data: 'customer',
        name: 'customer'
      },
      {
        data: 'saleId',
        name: 'saleId'
      },
      {
        data: 'total',
        name: 'total'
      }, {
        data: 'due',
        name: 'due'
      },

      {
        data: 'created_at',
        name: 'created_at'
      },
      {
        data: 'action',
        name: 'action'
      },
    ],
  });
</script>
@endpush