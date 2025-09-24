@extends('layouts.admin')

@section('content')
    <div>
        <h4>My Stores</h4>

        @if ($stores->count())
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="title-header font-weight-bold">Store List</div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Store Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->email ?? '-' }}</td>
                                    <td>{{ $store->phone ?? '-' }}</td>
                                    <td>{{ $store->address ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('stores.sales.index', $store->id) }}"
                                            class="btn btn-sm btn-primary" title="Sales History">
                                            <i class="fas fa-chart-line"></i>
                                        </a>
                                        <a href="{{ route('stores.products.index', $store->id) }}"
                                            class="btn btn-sm btn-primary" title="Manage Products">
                                             <i class="fas fa-box"></i>
                                        </a>
                                        <a href="{{ route('stores.cashiers.index', $store->id) }}"
                                            class="btn btn-sm btn-primary" title="Manage Cashiers">
                                             <i class="fas fa-users"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>No stores assigned to you yet.</p>
        @endif
    </div>
@endsection
