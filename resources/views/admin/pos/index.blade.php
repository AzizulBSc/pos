@extends('layouts.master')
@section('title', 'Product Sale')
@section('content')
<div class="page-heading">
  <x-page-title title="Product Sale" subtitle="" pageTitle="Product Sale" />
  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body" id="cart">
      </div>
    </div>
  </section>
  <!-- Basic Tables end -->
</div>
@endsection
@push('js')
<script>
</script>
@endpush