@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-primary">Sales</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="fas fa-cash-register"></i> New Sale
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Sales List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Cashier</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $sale->cashier->name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                        <td>₱{{ number_format($sale->discount, 2) }}</td>
                        <td>
                            <span class="badge badge-info text-uppercase">{{ $sale->payment_method }}</span>
                        </td>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-receipt"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No sales recorded yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection
