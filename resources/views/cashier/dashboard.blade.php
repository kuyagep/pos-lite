@extends('layouts.cashier')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Cashier Dashboard</h1>

    <div class="row">
        <!-- Total Sales Today -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Sales ({{ $today }})
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₱{{ number_format($totalSalesToday, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Today -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Transactions ({{ $today }})
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $transactionCountToday }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <a href="{{ route('pos.index') }}" class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-cash-register"></i> Go to POS
            </a>
        </div>
        <div class="col-md-6 mb-4">
            <a href="{{ route('sales.history') }}" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-history"></i> View Sales History
            </a>
        </div>
    </div>
</div>
@endsection
