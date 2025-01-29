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
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Supplier
            <address>
              <strong>Name: {{ $sale->customer->name }}</strong><br>
              <strong>Date: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</strong><br>
              <strong>No: #{{ $sale->id }}</strong><br>
            </address>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-md-12">
            <div class="card-body table-responsive p-0" id="table_data">
              <table id="datatables" class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th data-orderable="false">#</th>
                    <th>Product</th>
                    <th>Sale Price{{currency()->symbol??''}}</th>
                    <th>
                      Quantity
                    </th>
                    <th>
                      Sub Total{{currency()->symbol??''}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($sale->items as $key => $item)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->sale_price, 2) }}</td>
                    <td>{{ $item->quantity }} {{optional($item->product->unit)->short_name}}</td>
                    <td>{{ number_format(($item->sale_price * $item->quantity), 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- accepted payments column -->
          <div class="col-6">
            <!-- <p class="lead">Payment:Cash Paid</p> -->
            <!-- <small class="lead text-small text-bold">Payment:Cash Paid</small> -->
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              {{$sale->note??''}}
            </p>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <!-- <p class="lead">Amount Due 2/22/2014</p> -->

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td class="text-right">{{number_format($sale->sub_total,2,'.',',')}}</td>
                </tr>
                <tr>
                  <th>Tax:</th>
                  <td class="text-right">{{number_format($sale->tax,2,'.',',')}}</td>
                </tr>
                <tr>
                  <th>Discount:</th>
                  <td class="text-right">{{number_format($sale->discount_value,2,'.',',')}}</td>
                </tr>
                <tr>
                  <th>Shipping:</th>
                  <td class="text-right">{{number_format($sale->shipping,2,'.',',')}}</td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td class="text-right">{{number_format($sale->grand_total,2,'.',',')}}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- <div class="row no-print">
      <div class="col-12">
        <button type="button" onclick="window.print()" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>
        </button>
      </div>
    </div> -->
      </div>
    </div>
    @endsection