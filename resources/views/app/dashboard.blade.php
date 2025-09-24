@extends('layouts.super_admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">

        <!-- Total Stores -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Stores</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStores }}</div>
                </div>
            </div>
        </div>

        <!-- Total Owners -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Owners</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOwners }}</div>
                </div>
            </div>
        </div>

        <!-- Total Cashiers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Cashiers</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCashiers }}</div>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Sales</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">₱{{ number_format($totalSales, 2) }}</div>
                </div>
            </div>
        </div>

    </div>
@endsection
