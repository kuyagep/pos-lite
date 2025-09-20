@extends('layouts.admin')

@section('title', 'Edit Cashier')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Cashier: {{ $cashier->name }}</h1>

    <form action="{{ route('stores.cashiers.update', [$store->id, $cashier->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $cashier->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $cashier->email) }}" required>
        </div>

        <div class="form-group">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Cashier</button>
        <a href="{{ route('stores.cashiers.index', $store->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
