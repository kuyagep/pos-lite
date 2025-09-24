@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Activate License</div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('license.activate.submit') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="license_key">License Key</label>
                            <input type="text" name="license_key" id="license_key"
                                   class="form-control" placeholder="XXXX-YYYY-ZZZZ" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Activate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
