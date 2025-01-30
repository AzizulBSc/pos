<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
// use App\Models\SaleTransaction;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sales = Sale::with('customer')->latest();
            return DataTables::of($sales)
                ->addIndexColumn()
                ->addColumn('saleId', fn($data) => "#" . $data->id)
                ->addColumn('customer', fn($data) => $data->customer->name ?? '-')
                ->addColumn('item', fn($data) => $data->total_item)
                ->addColumn('sub_total', fn($data) => number_format($data->sub_total, 2, '.', ','))
                ->addColumn('discount', fn($data) => number_format($data->discount, 2, '.', ','))
                ->addColumn('total', fn($data) => number_format($data->total, 2, '.', ','))
                ->addColumn('paid', fn($data) => number_format($data->paid, 2, '.', ','))
                ->addColumn('due', fn($data) => number_format($data->due, 2, '.', ','))
                ->editColumn('created_at', fn($data) => $data->created_at->format('g:ia, d M, Y'))
                ->addColumn('status', fn($data) => $data->status
                    ? '<span class="badge bg-primary">Paid</span>'
                    : '<span class="badge bg-danger">Due</span>')
                ->addColumn('action', function ($row) {
                    return view('admin.sales.action', compact('row'));
                })
                ->rawColumns(['saleId', 'customer', 'created_at', 'item', 'sub_total', 'discount', 'total', 'paid', 'due', 'status', 'action'])
                ->toJson();
        }
        return view('admin.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => [
                'required',
                'exists:customers,id',
                'integer', // Ensure customer_id is an integer
            ],
            'order_discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'paid' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ], [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'order_discount.numeric' => 'The sale discount must be a number.',
            'paid.numeric' => 'The amount paid must be a number.',
        ]);
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);
        $totalAmountSale = 0;
        $orderDiscount = $request->order_discount;
        foreach ($carts as $cart) {
            $mainTotal = $cart->product->price * $cart->quantity;
            $totalAfterDiscount = $cart->product->discounted_price * $cart->quantity;
            $discount = $mainTotal - $totalAfterDiscount;
            $totalAmountSale += $totalAfterDiscount;
            $sale->products()->create([
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
                'sub_total' => $mainTotal,
                'discount' => $discount,
                'total' => $totalAfterDiscount,
                'product_id' => $cart->product->id,
            ]);
            $cart->product->quantity = $cart->product->quantity - $cart->quantity;
            $cart->product->save();
        }
        $total = $totalAmountSale - $orderDiscount;
        $due = $total - $request->paid;
        $sale->sub_total = $totalAmountSale;
        $sale->discount = $orderDiscount;
        $sale->paid = $request->paid;
        $sale->total = round((float)$total, 2);
        $sale->due = round((float)$due, 2);
        $sale->status = round((float)$due, 2) <= 0;
        $sale->save();
        //create sale transaction
        if ($request->paid > 0) {
            $orderTransaction = $sale->payments()->create([
                'amount' => $request->paid,
                'user_id' => auth()->id(),
                'payment_type' => 'cash',
                'transaction_type' => 'credit',
                'note' => 'Payment for sale',
            ]);
        }
        $data = [
            'siteName' => 'MyApp',
            'siteLogo' => asset('assets/images/no-image.png'),
            'currentDate' => now()->toDateString(),
            'siteDetails' => '123 Example Street, Example City phone 0183223232',
            'noteToCustomer' => 'Thank you for shopping with us!',
            'currencySymbol' => '$',
            'sale' => $sale->load(['customer', 'products.product']),
        ];
        $carts = Cart::where('user_id', auth()->id())->delete();
        return response()->json(['message' => 'Sale completed successfully', 'data' => $data], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function invoice($id)
    {
        $sale = Sale::with(['customer', 'products.product'])->findOrFail($id);
        return view('admin.sales.invoice', compact('sale'));
    }
    public function paymentCollection(Request $request, $id)
    {

        $sale = Sale::findOrFail($id);
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'amount' => 'required|numeric|min:1',
                'note' => 'nullable|string',
            ]);


            $due = $sale->due - $data['amount'];
            $paid = $sale->paid + $data['amount'];
            $sale->due = round((float)$due, 2);
            $sale->paid = round((float)$paid, 2);
            $sale->status = round((float)$due, 2) <= 0;
            $sale->save();
            $collection_amount = $data['amount'];
            //create sale transaction

            $orderTransaction = $sale->payments()->create([
                'amount' => $data['amount'],
                'user_id' => auth()->id(),
                'payment_type' => 'cash',
                'transaction_type' => 'credit',
                'note' => $data['note'],
            ]);
            return to_route('admin.sales.payments.invoice', $orderTransaction->id);
        }
        return view('admin.sales.payments.create', compact('sale'));
    }

    //collection invoice by order_transaction id
    public function collectionInvoice($id)
    {
        $transaction = Payment::findOrFail($id);
        $collection_amount = $transaction->amount;
        $sale = $transaction->sale;
        return view('admin.sales.payments.invoice', compact('sale', 'collection_amount', 'transaction'));
    }
    //transactions by sale id
    public function payments($id)
    {
        $sale = Sale::with('payments')->findOrFail($id);
        return view('admin.sales.payments.index', compact('sale',));
    }
}
