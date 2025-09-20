@extends('layouts.super_admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Store</h1>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Update Store Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('app.stores.update', $store->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Store Name -->
                <div class="form-group mb-3">
                    <label for="name">Store Name</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $store->name) }}"
                           class="form-control" required>
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email">Store Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $store->email) }}"
                           class="form-control">
                </div>

                <!-- Phone -->
                <div class="form-group mb-3">
                    <label for="phone">Store Phone</label>
                    <input type="text" name="phone" id="phone"
                           value="{{ old('phone', $store->phone) }}"
                           class="form-control">
                </div>

                <!-- Address -->
                <div class="form-group mb-3">
                    <label for="address">Store Address</label>
                    <textarea name="address" id="address"
                              class="form-control" rows="3">{{ old('address', $store->address) }}</textarea>
                </div>

                <!-- Owner (readonly for now) -->
                <div class="form-group mb-3">
                    <label for="owner">Owner</label>
                    <input type="text" class="form-control"
                           value="{{ $store->owner->name ?? 'N/A' }}" disabled>
                </div>

                <!-- Buttons -->
                <button type="submit" class="btn btn-primary">Update Store</button>
                <a href="{{ route('app.stores.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
