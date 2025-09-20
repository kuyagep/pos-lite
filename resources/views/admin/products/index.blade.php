@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Products for {{ $store->name }}</h4>
        <a href="{{ route('stores.products.create', $store->id) }}" class="btn btn-sm btn-success">
            + Add Product
        </a>
    </div>

    @if($products->count())
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price,2) }}</td>
                        <td>{{ $product->stock ?? '-' }}</td>
                        <td>
                            <a href="{{ route('stores.products.edit', [$store->id, $product->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('stores.products.destroy', [$store->id, $product->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <p>No products added for this store yet.</p>
    @endif
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function(e) {
                e.preventDefault(); // ✅ prevent default form submission or link action

                var productId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#003399', // ✅ custom theme color
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/products/' + productId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500, // ✅ auto close after 1.5 seconds
                                    timerProgressBar: true
                                });

                                // fade-out row removal instead of reload
                                $('#product-' + productId).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was an error deleting the product.',
                                    icon: 'error',
                                    confirmButtonColor: '#003399'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
