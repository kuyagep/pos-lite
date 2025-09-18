@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
    <!-- Total Registrations -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary  h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Registrations
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalRegistrations }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teaching Registrations -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success  h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Teaching
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $teachingCount }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Non-Teaching Registrations -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning  h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Non-Teaching
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $nonTeachingCount }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
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
        const ctx = document.getElementById('participantsChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie', // change to 'bar' if you want bar chart
            data: {
                labels: ['Teaching', 'Non-Teaching'],
                datasets: [{
                    data: [{{ $teachingCount }}, {{ $nonTeachingCount }}],
                    backgroundColor: ['#4e73df', '#1cc88a'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
