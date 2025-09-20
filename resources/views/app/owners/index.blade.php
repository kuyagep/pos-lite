@extends('layouts.super_admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Owners</h1>
        <a href="{{ route('app.owners.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Owner
        </a>
    </div>

    <!-- Owners Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Owners List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Owner Name</th>
                            <th>Email</th>
                            <th>Stores</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($owners as $index => $owner)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $owner->name }}</td>
                                <td>{{ $owner->email }}</td>
                                <td>
                                    @if($owner->stores->count())
                                        <ul class="mb-0">
                                            @foreach($owner->stores as $store)
                                                <li>{{ $store->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">No Stores Assigned</span>
                                    @endif
                                </td>
                                <td>{{ $owner->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('app.owners.edit', $owner->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('app.owners.destroy', $owner->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this owner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No owners found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
