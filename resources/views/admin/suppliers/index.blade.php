@extends('layouts.master')
@section('title', 'Supplier')
@section('content')
<div class="page-heading">
  <x-page-title title="Supplier" subtitle="" pageTitle="Supplier" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      {{-- <div class="card-header"><h5 class="card-title"></h5></div> --}}
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.suppliers.create')}}">Add Supplier</a>
        </div>

        <div class="table-responsive">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
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
    ajax: "{{ route('admin.suppliers.index') }}",
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false, // Prevent ordering
        searchable: false // Prevent searching
      },
      {
        data: 'name',
        name: 'name'
      },

      {
        data: 'phone',
        name: 'phone'
      },
      {
        data: 'address',
        name: 'address'
      },
      {
        data: 'action',
        name: 'action'
      },
    ],
  });
</script>
@endpush