@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Sales History - {{ $store->name }}</h1>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('stores.sales.index', $store->id) }}" class="d-flex align-items-center">
                    <select name="filter" class="form-control mr-2" onchange="this.form.submit()">
                        <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Custom Range</option>
                    </select>

                    @if ($filter === 'all')
                        <input type="date" name="from" value="{{ $from }}" class="form-control mx-2">
                        <input type="date" name="to" value="{{ $to }}" class="form-control mx-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    @endif
                </form>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card ">
            <div class="card-body">
                @if ($sales->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Reciept No</th>
                                    <th>Date</th>
                                    <th>Cashier</th>
                                    <th>Payment Method</th>
                                    <th>Discount</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                                        <td>{{ $sale->cashier->name ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($sale->payment_method) }}</td>
                                        <td>₱{{ number_format($sale->discount, 2) }}</td>
                                        <td><strong>₱{{ number_format($sale->total_amount, 2) }}</strong></td>
                                        <td>
                                            <a href="{{ route('stores.sales.show', [$store->id, $sale->id]) }}"
                                                class="btn btn-sm btn-primary" title="View Receipt">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $sales->appends(request()->query())->links() }}
                    </div>
                @else
                    <p class="text-center text-muted">No sales found for this period.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
