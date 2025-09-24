@extends('layouts.admin')

@section('content')
    <div >
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Products for {{ $store->name }}</h4>
            <a href="{{ route('stores.products.create', $store->id) }}" class="btn btn-sm btn-primary">
                + Add Product
            </a>
        </div>

        @if ($products->count())
            <div class="card mb-4">
                 <div class="card-header bg-primary text-white">
                    <div class="title-header font-weight-bold">Product List</div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('stores.products.show', [$store->id, $product->id]) }}"
                                            class="btn btn-sm btn-primary"> <i class="fas fa-eye"></i> </a>
                                        <a href="{{ route('stores.products.edit', [$store->id, $product->id]) }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> </a>
                                        <form action="{{ route('stores.products.destroy', [$store->id, $product->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this product?')"><i class="fas fa-trash-alt"></i></button>
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
