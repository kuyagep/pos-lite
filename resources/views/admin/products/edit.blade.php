@extends('layouts.admin')

@section('content')
<h1 class="h3 text-primary mb-4">Edit Product</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}">
            </div>

            <div class="form-group">
                <label for="price">Price (₱)</label>
                <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price', $product->price) }}">
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" class="form-control" required value="{{ old('stock', $product->stock) }}">
            </div>

            <div class="form-group">
                <label for="low_stock_alert">Low Stock Alert</label>
                <input type="number" name="low_stock_alert" class="form-control" value="{{ old('low_stock_alert', $product->low_stock_alert) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
