@extends('layouts.admin')

@section('title', 'Manage Cashiers')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Cashiers for {{ $store->name }}</h1>

    <a href="{{ route('stores.cashiers.create', $store->id) }}" class="btn btn-success mb-3">
        + Add Cashier
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cashiers->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashiers as $cashier)
                            <tr>
                                <td>{{ $cashier->name }}</td>
                                <td>{{ $cashier->email }}</td>
                                <td>{{ $cashier->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('stores.cashiers.edit', [$store->id, $cashier->id]) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <form action="{{ route('stores.cashiers.destroy', [$store->id, $cashier->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>No cashiers found for this store.</p>
    @endif
</div>
@endsection
