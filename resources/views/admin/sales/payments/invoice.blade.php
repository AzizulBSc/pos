@extends('layouts.master')
@section('title', 'Sale_Invoice_'.$payment->id)
@section('content')
<div class="card">
  <div class="card-body">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row mb-4">
        <div class="col-4">
          <h3 class="page-header">
            Your Business Name
          </h3>
        </div>
        <div class="col-4">
          <h4 class="page-header">Invoice</h4>
        </div>
        <div class="col-4">
          <small class="float-right text-small">Date: {{date('d/m/Y')}}</small>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <!-- /.col -->
        <div class="col-sm-5 invoice-col">
          To
          <address>
            <strong>Name: {{$sale->customer->name??"N/A"}}</strong><br>
            Address: {{$sale->customer->address??"N/A"}}<br>
            Phone: {{$sale->customer->phone??"N/A"}}<br>
          </address>
        </div>
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Name:Your Business Name</strong><br>
            Address: Dhaka<br>
            Phone:08422489274<br>
            Email: email@gmail.com<br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 invoice-col">
          Info <br>
          Sale ID #{{$sale->id}}<br>
          Sale Date: {{date('d/m/Y', strtotime($sale->created_at))}}<br>
          Payment Date: {{date('d/m/Y', strtotime($payment->created_at))}}<br>
          <!-- <br>
          <b>Payment Due:</b> 2/22/2014<br>
          <b>Account:</b> 968-34567 -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table">
            <thead>
              <tr>
                <td>SN</td>
                <td>Product</td>
                <td>Quantity</td>
                <td>Price {{currency()->symbol??''}}</td>
                <td>Subtotal {{currency()->symbol??''}}</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($sale->products as $item )
              <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$item->product->name}}</td>
                <td>{{$item->quantity}} {{optional($item->product->unit)->short_name}}</td>
                <td>
                  {{$item->product->discounted_price}}
                  @if ($item->product->price>$item->product->discounted_price)
                  <br><del>{{ $item->product->price }}</del>
                  @endif
                </td>
                <td>{{$item->total}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
          <!-- <p class="lead">Payment:Cash Paid</p> -->
          <!-- <small class="lead text-small text-bold">Payment:Cash Paid</small> -->
          <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
            Thank you Come Again
          </p>
        </div>
        <!-- /.col -->
        <div class="col-6">
          <!-- <p class="lead">Amount Due 2/22/2014</p> -->

          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width:50%">Subtotal:</td>
                <td class="text-right">{{currency()->symbol.' '.number_format($sale->sub_total,2,'.',',')}}</td>
              </tr>
              <tr>
                <td>Discount:</td>
                <td class="text-right">{{currency()->symbol.' '.number_format($sale->discount,2,'.',',')}}</td>
              </tr>
              <tr>
                <td>Total:</td>
                <td class="text-right">{{currency()->symbol.' '.number_format($sale->total,2,'.',',')}}</td>
              </tr>
              <tr>
                <td>Previously Paid:</th>
                <td class="text-right">{{currency()->symbol.' '.number_format($sale->paid - $collection_amount,2,'.',',')}}</td>
              </tr>
              <tr>
                <td>Collection Amount: <sup>{{date('d/m/Y', strtotime($payment->created_at))}}</sup></th>
                <td class="text-right">{{currency()->symbol.' '.number_format($collection_amount,2,'.',',')}}</td>
              </tr>
              <tr>
                <td>Due:</td>
                <td class="text-right">{{currency()->symbol.' '.number_format($sale->due,2,'.',',')}}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <div class="row no-print">
        <div class="col-12">
          <button type="button" onclick="window.print()" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>
          </button>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
@endsection

@push('css')
@push('css')
<style>
  .invoice {
    bsale: none !important;
  }

  thead {
    font-weight: bold !important;
  }

  @media print {
    body * {
      visibility: hidden;
      /* Hide everything by default */
    }

    .invoice,
    .invoice * {
      visibility: visible;
      /* Make only the invoice visible */
    }

    .invoice {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }

    .no-print {
      display: none !important;
      /* Hide elements with the class 'no-print' */
    }
  }
</style>
@endpush

@endpush
@push('script')
<script>
  window.addEventListener("load", window.print());
</script>
@endpush