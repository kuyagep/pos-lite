@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Cashiers</h1>

    <!-- Add Cashier Button -->
    <a href="{{ route('cashiers.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Cashier
    </a>

    <!-- Cashiers Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <h6 class="m-0 font-weight-bold text-white">Cashiers List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cashiers as $index => $cashier)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $cashier->name }}</td>
                                <td>{{ $cashier->email }}</td>
                                <td>{{ $cashier->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('cashiers.edit', $cashier->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('cashiers.destroy', $cashier->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this cashier?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No cashiers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
