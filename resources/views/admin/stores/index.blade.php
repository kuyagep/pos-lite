@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h4>My Stores</h4>

        @if ($stores->count())
            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Store Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->email ?? '-' }}</td>
                                    <td>{{ $store->phone ?? '-' }}</td>
                                    <td>{{ $store->address ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('stores.products.index', $store->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Manage Products
                                        </a>
                                        <a href="{{ route('stores.cashiers.index', $store->id) }}"
                                            class="btn btn-sm btn-success">
                                            Manage Cashiers
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
