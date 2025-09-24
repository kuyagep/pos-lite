@extends('layouts.admin')

@section('title', 'Manage Cashiers')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="h3 mb-4 text-gray-800">Cashiers for {{ $store->name }}</h4>
            <a href="{{ route('stores.cashiers.create', $store->id) }}" class="btn btn-primary btn-sm mb-3">
                + Add Cashier
            </a>
        </div>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($cashiers->count() > 0)
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashiers as $cashier)
                                <tr>
                                    <td>{{ $cashier->name }}</td>
                                    <td>{{ $cashier->email }}</td>
                                    <td>{{ $cashier->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('stores.cashiers.edit', [$store->id, $cashier->id]) }}"
                                            class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>

                                        <form action="{{ route('stores.cashiers.destroy', [$store->id, $cashier->id]) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> </button>
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
