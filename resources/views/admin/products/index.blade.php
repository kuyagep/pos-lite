@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-primary">Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Product List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>QR</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category ?? '-' }}</td>
                                <td>₱{{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if ($product->stock <= $product->low_stock_alert)
                                        <span class="badge badge-danger">{{ $product->stock }} (Low)</span>
                                    @else
                                        <span class="badge badge-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->qr_code)
                                       {!! QrCode::size(60)->generate($product->qr_code) !!}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
