@extends('layouts.super_admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Add Store</h1>

    <form action="{{ route('app.stores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Store Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email (unique)</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
        </div>
       
        <!-- Owner (hidden field if pre-selected) -->
        @if ($owner)
            <input type="hidden" name="owner_id" value="{{ $owner->id }}">
            <div class="form-group mb-3">
                <label>Owner</label>
                <input type="text" class="form-control" value="{{ $owner->name }}" disabled>
            </div>
        @else
            <div class="form-group mb-3">
                <label for="owner_id">Assign to Owner</label>
                <select name="owner_id" id="owner_id" class="form-control" required>
                    <option value="">-- Select Owner --</option>
                    @foreach ($owners as $ownerOption)
                        <option value="{{ $ownerOption->id }}" {{ old('owner_id') == $ownerOption->id ? 'selected' : '' }}>
                            {{ $ownerOption->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('app.stores.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
