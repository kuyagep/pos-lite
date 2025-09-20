@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Checkout</h2>

    <div class="card">
        <div class="card-body">
            <!-- Cart Table -->
    <table class="table table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>₱{{ number_format($item['price'], 2) }}</td>
                    <td>₱{{ number_format($item['subtotal'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center ">Cart is empty</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><b>Total Items</b></td>
                <td>{{ $totalItems }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-end"><b>Subtotal</b></td>
                <td>₱{{ number_format($subtotal, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Checkout Form -->
    <form id="confirmPaymentForm">
        @csrf
        <div class="mb-3">
            <label>Discount (₱)</label>
            <input type="number" step="0.01" name="discount" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label>Customer Name / Notes</label>
            <input type="text" name="customer_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control">
                <option value="cash">Cash</option>
                <option value="gcash">GCash</option>
                <option value="card">Card</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Confirm Payment</button>
        <a href="{{ route('pos.index') }}" class="btn btn-primary">Back to POS</a>
    </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#confirmPaymentForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('pos.confirm') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful',
                    text: res.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "/pos/receipt/" + res.sale_id;
                });
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON.error, 'error');
            }
        });
    });
</script>
@endpush
