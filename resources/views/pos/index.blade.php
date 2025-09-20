@extends('layouts.cashier')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-primary">Point of Sale</h1>

        {{-- Scanner --}}
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <video id="preview" class="w-100 border rounded"></video>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Cart</h5>
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-body">
                                        @php
                                            $totalItems = 0;
                                            $grandTotal = 0;
                                        @endphp
                                        @forelse($cart as $id => $item)
                                            @php
                                                $totalItems += $item['quantity'];
                                                $grandTotal += $item['subtotal'];
                                            @endphp
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>₱{{ number_format($item['price'], 2) }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>₱{{ number_format($item['subtotal'], 2) }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="removeFromCart('{{ $id }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No items in cart</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot id="cart-totals">
                                        <tr class="fw-bold">
                                            <td colspan="2" class="text-end">Total Items:</td>
                                            <td>{{ $totalItems }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td colspan="3" class="text-end"><b>Grand Total:</b></td>
                                            <td colspan="2"><b>₱ {{ number_format($grandTotal, 2) }}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                {{-- Checkout Button --}}
                                <a href="{{ route('pos.checkout') }}" class="btn btn-success w-100 mt-3">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        // Scan QR → add product via AJAX
        scanner.addListener('scan', function(content) {
            $.ajax({
                url: "{{ route('pos.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    qr_code: content
                },
                success: function(res) {
                    if (res.success) {
                        updateCart(res.cart); // ✅ update table dynamically
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function(err) {
                    Swal.fire('Not Found', 'Product not found!', 'warning');
                }
            });
        });

        // Start scanner
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });

        // Render cart dynamically
        function updateCart(cart) {
            window.currentCart = cart; // store for reuse
            let tbody = $('#cart-body');
            let tfoot = $('#cart-totals');

            tbody.empty();
            tfoot.empty();

            if ($.isEmptyObject(cart)) {
                tbody.html('<tr><td colspan="5" class="text-center">Cart is empty</td></tr>');
                return;
            }

            let totalItems = 0;
            let grandTotal = 0;

            $.each(cart, function(id, item) {
                let subtotal = item.price * item.quantity;
                totalItems += item.quantity;
                grandTotal += subtotal;

                let row = `
                <tr>
                    <td>${item.name}</td>
                    <td>₱${parseFloat(item.price).toFixed(2)}</td>
                    <td>${item.quantity}</td>
                    <td>₱${(item.price * item.quantity).toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFromCart('${id}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
                tbody.append(row);
            });


            // ✅ Cart Totals row
            let totalsRow = `
                    <tr class="fw-bold">
                        <td colspan="2" class="text-end">Total Items:</td>
                        <td>${totalItems}</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end"><b>Grand Total:</b></td>
                        <td colspan="2"><b>₱ ${grandTotal.toFixed(2)}</b></td>
                    </tr>
                `;
            tfoot.append(totalsRow);

            // Recalculate totals
            let discountPercent = parseFloat($('#discount').val()) || 0;
            grandTotal = subtotal - (subtotal * discountPercent / 100);

            $('#subtotal').text(subtotal.toFixed(2));
            $('#totalItems').text(totalItems);
            $('#discountDisplay').text(discountPercent + '%');
            $('#grandTotal').text(grandTotal.toFixed(2));

        }

        // 🔥 Recalculate when discount changes
        $(document).on('input', '#discount', function() {
            alert('Discount changed');
            updateCart(window.currentCart);
        });


        // Remove product from cart
        function removeFromCart(id) {
            $.ajax({
                url: `{{ route('pos.remove') }}`,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id
                },
                success: function(data) {
                    updateCart(data.cart); // ✅ re-render cart
                },
                error: function(err) {
                    Swal.fire('Error', 'Failed to remove product from cart.', 'error');
                }
            });
        }
    </script>


    <script>
        //checkout btn
        $(document).ready(function() {
            $('#checkout-btn').on('click', function(e) {
                e.preventDefault();

                let discount = $('#discount').val() || 0;
                let customerName = $('#customer_name').val() || '';

                Swal.fire({
                    title: 'Confirm Checkout',
                    text: 'Do you want to finalize this sale?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#003399',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Checkout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('pos.checkout') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                discount: discount,
                                customer_name: customerName
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Sale completed successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    updateCart({}); // ✅ clear cart UI
                                    $('#discount').val('');
                                    $('#customer_name').val('');
                                });
                            },
                            error: function(err) {
                                Swal.fire('Error!', 'Checkout failed.', 'error');
                            }
                        });
                    }
                });
            });
        });

        // clear cart
        $(document).ready(function() {
            $('#clear-cart-btn').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Clear Cart?',
                    text: "This will remove all items from the cart.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#003399',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('pos.clear') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                updateCart(res.cart); // ✅ re-render empty cart
                                Swal.fire({
                                    title: 'Cleared!',
                                    text: 'Cart has been emptied.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function(err) {
                                Swal.fire('Error!', 'Failed to clear cart.', 'error');
                            }
                        });
                    }
                });
            });
        });

        // Confirm Checkout in Modal
        $('#confirmCheckout').on('click', function(e) {
            e.preventDefault();

            let formData = {
                _token: "{{ csrf_token() }}",
                customer_name: $('#customer_name').val(),
                discount: $('#discount').val(),
                payment_method: $('#payment_method').val()
            };

            $.ajax({
                url: "{{ route('pos.checkout') }}",
                method: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Payment Successful!',
                            text: "Transaction completed with " + res.payment_method
                                .toUpperCase(),
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            $('#checkoutModal').modal('hide');
                            updateCart({}); // reset cart
                        });
                    }
                },
                error: function(err) {
                    Swal.fire("Error", "Checkout failed. Try again.", "error");
                }
            });
        });
    </script>
@endpush
