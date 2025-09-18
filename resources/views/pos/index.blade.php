@extends('layouts.admin')

@section('content')
<h1 class="h3 text-primary mb-4">Point of Sale</h1>

<div class="row">
    <!-- QR Scanner -->
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Scan Product QR</h5>
                <video id="preview" class="w-100 rounded border"></video>
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Cart</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <tr>
                            <td colspan="5" class="text-center">Cart is empty</td>
                        </tr>
                    </tbody>
                </table>

                <form id="checkout-form" action="{{ route('pos.checkout') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Discount (₱)</label>
                        <input type="number" name="discount" class="form-control" value="0">
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

scanner.addListener('scan', function(content) {
    $.ajax({
        url: "{{ route('pos.add') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: content
        },
        success: function(data) {
            updateCart(data.cart);
        },
        error: function(err) {
            console.error(err);
        }
    });
});

Instascan.Camera.getCameras().then(function(cameras){
    if(cameras.length > 0){
        scanner.start(cameras[0]);
    } else {
        alert('No cameras found.');
    }
}).catch(function(e){
    console.error(e);
});

function updateCart(cart){
    let tbody = $('#cart-body');
    tbody.empty();
    if($.isEmptyObject(cart)){
        tbody.html('<tr><td colspan="5" class="text-center">Cart is empty</td></tr>');
        return;
    }

    $.each(cart, function(id, item){
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
}

function removeFromCart(productId){
    $.ajax({
        url: "{{ route('pos.remove') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId
        },
        success: function(data){
            updateCart(data.cart);
        },
        error: function(err){
            console.error(err);
        }
    });
}
</script>
@endpush
