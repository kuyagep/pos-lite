@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        <!-- Daily Sales Summary Cards -->
        <div class="row">

            <!-- Total Sales -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Sales (Today)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ₱{{ number_format($todaySales, 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Transactions (Today)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $todayTransactions }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-receipt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Sale -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Avg Sale</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ₱{{ number_format($todayTransactions > 0 ? $todaySales / $todayTransactions : 0, 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discounts -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Discounts (Today)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ₱{{ number_format($todayDiscounts, 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percent fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center" style="height:300px;">
                            <canvas id="salesChart" style="width:100%; max-width: 100%; height:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Transactions Breakdown -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Payment Methods</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                            <canvas id="paymentPieChart" style="max-width: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart - Sales Overview
        const ctx = document.getElementById("salesChart").getContext("2d");
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesDates) !!}, // e.g. ["2025-09-01", "2025-09-02"]
                datasets: [{
                    label: "Sales",
                    data: {!! json_encode($salesTotals) !!}, // e.g. [1200, 1500, 2000]
                    borderColor: "#4e73df",
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    fill: true,
                    tension: 0.4,
                }]
            }
        });

        // Pie Chart - Payment Methods
        const ctxPie = document.getElementById("paymentPieChart").getContext("2d");
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: {!! json_encode($paymentMethods) !!}, // e.g. ["Cash", "GCash", "Card"]
                datasets: [{
                    data: {!! json_encode($paymentCounts) !!}, // e.g. [50, 20, 10]
                    backgroundColor: ["#1cc88a", "#36b9cc", "#f6c23e"],
                }]
            }
        });
    </script>
@endpush
