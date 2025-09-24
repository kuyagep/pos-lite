@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Header -->
            <div class="text-center mb-4">
                <h3 class="text-primary">{{$store->name}}</h3>
                <p class="mb-0">Thank you for your purchase!</p>
                <small>{{ now()->format('F d, Y h:i A') }}</small>
            </div>
             <!-- Transaction Info -->
            <div class="mb-3">
                <span><strong>Receipt No:</strong> {{ $sale->id }}</span> <br>
                <span><strong>Date:</strong> {{ $sale->created_at->format('M d, Y h:i A') }}</span> <br>
                <span><strong>Cashier:</strong> {{ $sale->cashier->name ?? 'N/A' }}</span> <br>
                <span><strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }}</span> <br>
                @if($sale->notes)
                    <span><strong>Customer:</strong> {{ $sale->notes }}</span>
                @endif
            </div>

            <hr>
            <table class="table table-sm table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                        <td class="text-end">₱{{ number_format($sale->items->sum('subtotal'), 2) }}</td>
                    </tr>
                    @if($sale->discount > 0)
                        <tr>
                            <td colspan="3" class="text-end"><strong>Discount</strong></td>
                            <td class="text-end">- ₱{{ number_format($sale->discount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-end"><strong>Grand Total</strong></td>
                        <td class="text-end fw-bold">₱{{ number_format($sale->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-3">
                <a href="{{ route('stores.sales.index', $sale->store->id) }}" class="btn btn-secondary">Back</a>
                <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
            </div>
        </div>
    </div>
</div>
@endsection
