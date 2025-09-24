@extends('layouts.super_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-800">Manage Stores</h1>
    {{-- <a href="{{ route('app.stores.create') }}" class="btn btn-primary">+ Add Store</a> --}}
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Email</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->email }}</td>
                    <td>{{ $store->owner?->name }}</td>
                    <td>{{ $store->phone }}</td>
                    <td>{{ $store->address }}</td>
                    <td>
                        <a href="{{ route('app.stores.show', $store->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('app.stores.edit', $store->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('app.stores.destroy', $store->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this store?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No stores found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $stores->links() }}
    </div>
</div>
@endsection
