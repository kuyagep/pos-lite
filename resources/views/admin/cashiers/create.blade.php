@extends('layouts.admin')

@section('title', 'Add Cashier')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Cashier to {{ $store->name }}</h1>

    <form action="{{ route('stores.cashiers.store', $store->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Cashier</button>
        <a href="{{ route('stores.cashiers.index', $store->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
