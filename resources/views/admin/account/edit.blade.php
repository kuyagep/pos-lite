@extends('layouts.admin')

@section('content')
<div>
    <h1 class="h3 mb-4 text-gray-800">Account Settings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8 col-lg-6 col-sm-12">
            <div class="card ">
        <div class="card-body">
            <form action="{{ route('account.update') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary fw-bold">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
