@extends('layouts.master')
@section('title', 'Purchase')
@section('content')
<div class="page-heading">
  <x-page-title title="Purchase" subtitle="" pageTitle="Purchase" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      {{-- <div class="card-header"><h5 class="card-title"></h5></div> --}}
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.purchases.create')}}">Add Purchase</a>
        </div>

        <div class="table-responsive">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Supplier</th>
                <th>Invoice</th>
                <th>Total</th>
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
    ajax: "{{ route('admin.purchases.index') }}",
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false, // Prevent ordering
        searchable: false // Prevent searching
      },
      {
        data: 'supplier',
        name: 'supplier'
      },
      {
        data: 'id',
        name: 'id'
      },
      {
        data: 'total',
        name: 'total'
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