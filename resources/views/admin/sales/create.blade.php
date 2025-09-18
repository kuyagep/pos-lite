@extends('layouts.admin')

@section('content')
<h1 class="h3 text-primary mb-4">New Sale</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Products</label>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Select</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Available Stock</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" name="products[{{ $loop->index }}][id]"
                                           value="{{ $product->id }}">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>₱{{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <input type="number" name="products[{{ $loop->index }}][quantity]"
                                           class="form-control" min="1" value="1">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <label for="discount">Discount (₱)</label>
                <input type="number" step="0.01" name="discount" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select name="payment_method" class="form-control" required>
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                    <option value="card">Card</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Record Sale
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
