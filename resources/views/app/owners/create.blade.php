@extends('layouts.super_admin')

@section('content')
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800">Create Owner + Store</h1>

        <form action="{{ route('app.owners.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h5>Owner Information</h5>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Store Information</h5>
                    <div class="form-group">
                        <label>Store Name</label>
                        <input type="text" name="store_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Store Email</label>
                        <input type="email" name="store_email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="store_phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="store_address" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Owner + Store</button>
        </form>
    </div>
@endsection
