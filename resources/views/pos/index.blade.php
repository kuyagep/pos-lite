@extends('layouts.cashier')
@push('styles')
    <style>
        .product-tile {
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            background: #fff;
        }

        .product-tile:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-image img {
            max-height: 120px;
            margin: auto;
            display: block;
        }

        .category-btn {
            min-width: 100px;
            border-radius: 8px;
        }

        .category-btn.active {
            background: #003399;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-primary">Point of Sale</h1>

        <div class="row">
            <!-- Left Side: Scanner + Products -->
            <div class="col-md-12 col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <video id="preview" class="w-100 border rounded"></video>
                    </div>
                </div>


                <!-- Products -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Available Products</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                    <!-- Search Bar -->
                    <div class="col-md-6 mx-auto">
                        <!-- Search Bar -->
                        <div class="mb-3">
                            <input type="text" id="product-search" class="form-control"
                                placeholder="🔍 Search items here…">
                        </div>
                    </div>
                </div>
                <!-- Category Filter -->
                <div class="d-flex mb-3 flex-wrap">
                    <button class="btn btn-primary me-2 mr-2 mb-2 category-btn" data-category="all">All</button>
                    @foreach ($categories as $cat)
                        <button class="btn btn-outline-primary me-2 mr-2 mb-2 category-btn"
                            data-category="{{ $cat }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
                        <div id="product-list" class="row g-4">
                            @foreach ($products as $product)
                                <div class="col-md-3 mb-3 product-card "  data-category="{{ $product->category }}"
                                    data-name="{{ strtolower($product->name) }}">
                                    <div class="card h-100 product-tile">
                                        <img src="{{ $product->image_url ?? 'https://placehold.co/200' }}"
                                            class="card-img-top img-fluid" style="height:150px; object-fit:cover;"
                                            alt="{{ $product->name }}">
                                        <div class="card-body text-center d-flex flex-column">
                                            <h6 class="card-title text-success">{{ $product->name }}</h6>
                                            <p class="mb-1 text-muted">₱{{ number_format($product->price, 2) }}</p>
                                            <small class="text-secondary">Stock: {{ $product->stock }}</small>
                                            <button class="btn btn-sm btn-success mt-auto add-to-cart"
                                                data-qr="{{ $product->qr_code }}">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>

            <!-- Right Side: Cart -->
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Cart</h6>
                        <button id="clear-cart-btn" class="btn btn-sm btn-danger">Clear</button>
                    </div>
                    <div class="card-body">
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
                                                onclick="removeFromCart('{{ $item['id'] }}')">
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
                        <button class="btn btn-success w-50 mt-3" id="checkout-btn">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        // ----------------------------
        // QR SCANNER
        // ----------------------------
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        scanner.addListener('scan', function(content) {
            addToCartAjax(content);
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found.');
            }
        }).catch(e => console.error(e));

        // ----------------------------
        // ADD TO CART (click + scan)
        // ----------------------------
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            let qr = $(this).data('qr');
            addToCartAjax(qr);
        });

        function addToCartAjax(qr) {
            $.post("{{ route('pos.add') }}", {
                _token: "{{ csrf_token() }}",
                qr_code: qr
            }, function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    updateCart(res.cart);
                }
            }).fail(() => Swal.fire('Error', 'Product not found or could not be added.', 'error'));
        }

        // ----------------------------
        // UPDATE CART RENDER
        // ----------------------------
        function updateCart(cart) {
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
                totalItems += item.quantity;
                grandTotal += item.subtotal;

                tbody.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>₱${parseFloat(item.price).toFixed(2)}</td>
                    <td>${item.quantity}</td>
                    <td>₱${item.subtotal.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFromCart('${id}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            });

            tfoot.append(`
            <tr class="fw-bold">
                <td colspan="2" class="text-end">Total Items:</td>
                <td>${totalItems}</td>
                <td colspan="2"></td>
            </tr>
            <tr class="fw-bold">
                <td colspan="3" class="text-end"><b>Grand Total:</b></td>
                <td colspan="2"><b>₱ ${grandTotal.toFixed(2)}</b></td>
            </tr>
        `);
        }

        // ----------------------------
        // REMOVE ITEM
        // ----------------------------
        function removeFromCart(id) {
            $.ajax({
                url: "{{ route('pos.remove') }}", // route('pos.remove') should be defined
                type: "POST", // use POST and spoof DELETE
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE", // Laravel needs this to treat it as DELETE
                    product_id: id
                },
                success: function(res) {
                    if (res.success) {
                        updateCart(res.cart); // refresh cart UI
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Product removed from cart.',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Failed to remove product.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to remove product.', 'error');
                }
            });
        }


        // ----------------------------
        // CLEAR CART
        // ----------------------------
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
                    $.post("{{ route('pos.clear') }}", {
                        _token: "{{ csrf_token() }}"
                    }, function(res) {
                        updateCart(res.cart);
                    });
                }
            });
        });

        // ----------------------------
        // CHECKOUT
        // ----------------------------
        $('#checkout-btn').on('click', function(e) {
            e.preventDefault();
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
                    window.location.href = "{{ route('pos.checkout') }}";
                }
            });
        });



        let activeCategory = "all";

        // Category filter
        $(document).on('click', '.category-btn', function() {
            activeCategory = $(this).data('category');
            filterProducts();

            $('.category-btn').removeClass('btn-primary').addClass('btn-outline-primary');
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        });

        // Search filter
        $('#product-search').on('keyup', function() {
            filterProducts();
        });

        // Combined filter function
        function filterProducts() {
            let query = $('#product-search').val().toLowerCase();

            $('.product-card').each(function() {
                let name = $(this).data('name');
                let category = $(this).data('category');

                let matchesSearch = name.includes(query);
                let matchesCategory = (activeCategory === "all" || category === activeCategory);

                if (matchesSearch && matchesCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
@endpush
