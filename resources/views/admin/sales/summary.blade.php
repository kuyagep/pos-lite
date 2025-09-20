@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Daily Sales Summary</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="card-title">Date</h5>
                <p class="h4">{{ \Carbon\Carbon::parse($today)->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="card-title">Total Sales</h5>
                <p class="h4 text-success">₱ {{ number_format($totalSales, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="card-title">Transactions</h5>
                <p class="h4">{{ $transactionCount }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
