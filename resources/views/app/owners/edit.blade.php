@extends('layouts.super_admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Edit Owner</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('app.owners.update', $owner->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Owner Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $owner->name) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="email">Owner Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $owner->email) }}"
                            required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (leave blank if unchanged)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>


                    <button type="submit" class="btn btn-primary">Update Owner</button>
                    <a href="{{ route('app.owners.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

        {{-- Stores list --}}
        <div class="card shadow mb-4 mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Stores Belonging to {{ $owner->name }}</h6>
                <a href="{{ route('app.stores.create', ['owner_id' => $owner->id]) }}" class="btn btn-sm btn-success">
                    + Add Store
                </a>
            </div>
            <div class="card-body">
                @if ($owner->stores->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Store Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th class="text-center" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($owner->stores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->email ?? '-' }}</td>
                                    <td>{{ $store->phone ?? '-' }}</td>
                                    <td>{{ $store->address ?? '-' }}</td>
                                     <td class="text-center">
                                <a href="{{ route('app.stores.show', $store->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('app.stores.edit', $store->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No stores assigned to this owner yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
