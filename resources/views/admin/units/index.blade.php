@extends('layouts.master')
@section('title', 'Unit')
@section('content')
<div class="page-heading">
  <x-page-title title="Unit" subtitle="" pageTitle="Unit" />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      {{-- <div class="card-header"><h5 class="card-title"></h5></div> --}}
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.units.create')}}">Add Unit</a>
        </div>

        <div class="table-responsive">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Short Name</th>
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
    ajax: "{{ route('admin.units.index') }}",
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
        data: 'short_name',
        name: 'short_name'
      },
      {
        data: 'action',
        name: 'action'
      },
    ],
  });
</script>
@endpush