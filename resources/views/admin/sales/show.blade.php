@extends('layouts.admin')

@section('content')
<h1 class="h3 text-primary mb-4">Sale Receipt</h1>

<div class="card shadow">
    <div class="card-body">
        <h5>Sale ID: {{ $sale->id }}</h5>
        <p><strong>Date:</strong> {{ $sale->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Cashier:</strong> {{ $sale->user->name ?? 'N/A' }}</p>
        <p><strong>Payment Method:</strong> {{ strtoupper($sale->payment_method) }}</p>

        <hr>

        <h6>Items</h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>₱{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <p><strong>Discount:</strong> ₱{{ number_format($sale->discount, 2) }}</p>
            <h5 class="text-success"><strong>Total:</strong> ₱{{ number_format($sale->total_amount, 2) }}</h5>
        </div>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Back to Sales</a>
    </div>
</div>
@endsection
