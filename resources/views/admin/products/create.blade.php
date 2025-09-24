@extends('layouts.admin')

@section('content')
<div >
    <h4>Add Product to {{ $store->name }}</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('stores.products.store', $store->id) }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="categoy">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
        </div>
        <div class="form-group mb-3">
            <label for="low_stock_alert">Low Stock Alert</label>
            <input type="number" name="low_stock_alert" class="form-control" value="{{ old('low_stock_alert') }}">
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Add Product</button>
        <a href="{{ route('stores.products.index', $store->id) }}" class="btn btn-secondary btn-sm">Cancel</a>
    </form>
        </div>
    </div>
</div>
@endsection
