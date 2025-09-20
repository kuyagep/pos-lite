@extends('layouts.cashier')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Sales History</h1>

    <!-- Filter Buttons -->
    <div class="mb-3">
        <form method="GET" action="{{ route('sales.history') }}">
            <div class="btn-group" role="group" aria-label="Filter Sales">
                <button type="submit" name="filter" value="today"
                    class="btn btn-sm {{ request('filter') == 'today' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Today
                </button>
                <button type="submit" name="filter" value="week"
                    class="btn btn-sm {{ request('filter') == 'week' ? 'btn-primary' : 'btn-outline-primary' }}">
                    This Week
                </button>
                <button type="submit" name="filter" value="all"
                    class="btn btn-sm {{ request('filter') == 'all' || !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                    All
                </button>
            </div>
        </form>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Transactions</h6>
        </div>
        <div class="card-body">
            @if($sales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Date</th>
                                <th>Transaction ID</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                    <td>#{{ $sale->id }}</td>
                                    <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                                    <td>₱{{ number_format($sale->discount, 2) }}</td>
                                    <td>{{ ucfirst($sale->payment_method) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $sales->appends(request()->query())->links() }}
                </div>
            @else
                <p class="text-center text-muted">No sales recorded yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
