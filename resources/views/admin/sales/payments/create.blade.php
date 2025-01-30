@extends('layouts.master')
@section('title', 'Payment Collection ')
@section('content')
<div class="page-heading">
  <x-page-title title="Payment Collection Create" subtitle="" pageTitle="Payment Collection " />

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="my-4">
          <a class="btn btn-secondary" href="{{route('admin.sales.payments',$sale->id)}}">All Payments</a>
        </div>
        <form action="{{ route('admin.sales.payments.create',$sale->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="due_amount" class="form-label">
                  Due Amount<sup class="text-danger">*</sup></label>
                <input type="number"
                  class="form-control" value="{{ $sale->due }}" readonly disabled>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="amount" class="form-label">
                  Amount<sup class="text-danger">*</sup></label>
                <input type="number" min="1" max="{{$sale->due}}" name="amount" id="amount" placeholder="amount"
                  class="form-control" value="{{ old('amount',$sale->due) }}" required>
                @error('amount')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="note" class="form-label">Note</label>
                 <textarea name="note" id="note" class="form-control" placeholder="Note">{{ old('note') }}</textarea>

                @error('note')
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