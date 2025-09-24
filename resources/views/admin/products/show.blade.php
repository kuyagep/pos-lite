@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-primary">Product Details</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="mb-4">{{ $product->name }}</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 200px;">Product Code</th>
                                <td>{{ $product->qr_code ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px;">Category</th>
                                <td>{{ $product->category ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Price</th>
                                <td>₱{{ number_format($product->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Stock</th>
                                <td>{{ $product->stock }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Low Stock Alert</th>
                                <td>{{ $product->low_stock_alert }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('stores.products.index', $store->id) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('stores.products.edit', [$store->id, $product->id]) }}"
                        class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">QR Code</h5>
                    @if ($product->qr_code)
                        {!! QrCode::size(200)->generate($product->qr_code) !!}
                        <p class="mt-2 text-muted small">Scan this QR to add product in POS</p>
                    @else
                        <p class="text-danger">No QR code generated.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
