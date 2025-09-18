@extends('layouts.admin')

@section('content')
<h1 class="h3 text-primary mb-4">Add Product</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}">
            </div>

            <div class="form-group">
                <label for="price">Price (₱)</label>
                <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label for="stock">Initial Stock</label>
                <input type="number" name="stock" class="form-control" required value="{{ old('stock') }}">
            </div>

            <div class="form-group">
                <label for="low_stock_alert">Low Stock Alert</label>
                <input type="number" name="low_stock_alert" class="form-control" value="{{ old('low_stock_alert', 5) }}">
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
