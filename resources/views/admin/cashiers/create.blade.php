@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h3>Add Cashier</h3>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('cashiers.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Cashier</button>
                </form>
            </div>
        </div>
    </div>
@endsection
