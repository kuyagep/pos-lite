@extends('layouts.cashier')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header -->
            <div class="text-center mb-4">
                <h3 class="text-primary">Store Receipt</h3>
                <p class="mb-0">Thank you for your purchase!</p>
                <small>{{ now()->format('F d, Y h:i A') }}</small>
            </div>

            <!-- Transaction Info -->
            <div class="mb-3">
                <p><strong>Receipt No:</strong> #{{ $transaction->id }}</p>
                <p><strong>Cashier:</strong> {{ $transaction->cashier->name ?? 'N/A' }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($transaction->payment_method) }}</p>
                @if($transaction->notes)
                    <p><strong>Customer:</strong> {{ $transaction->notes }}</p>
                @endif
            </div>

            <!-- Items Table -->
            <table class="table table-sm table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Unknown' }}</td>
                            <td class="text-end">₱{{ number_format($item->price, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                        <td class="text-end">₱{{ number_format($transaction->items->sum('subtotal'), 2) }}</td>
                    </tr>
                    @if($transaction->discount > 0)
                        <tr>
                            <td colspan="3" class="text-end"><strong>Discount</strong></td>
                            <td class="text-end">- ₱{{ number_format($transaction->discount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-end"><strong>Grand Total</strong></td>
                        <td class="text-end fw-bold">₱{{ number_format($transaction->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Footer -->
            <div class="text-center mt-4">
                <p class="mb-0">This serves as your official receipt.</p>
                <p class="text-muted"><small>Powered by GCM POSLite</small></p>
                <button onclick="window.print()" class="btn btn-primary mt-2">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <a href="{{ route('pos.index') }}" class="btn btn-secondary mt-2">Back to POS</a>
            </div>
        </div>
    </div>
</div>
@endsection
