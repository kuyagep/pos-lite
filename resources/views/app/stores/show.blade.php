@extends('layouts.super_admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Store Details</h1>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $store->name }}</h6>
            <a href="{{ route('app.stores.index') }}" class="btn btn-secondary btn-sm">Back to Stores</a>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Store Name</dt>
                <dd class="col-sm-9">{{ $store->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $store->email ?? '-' }}</dd>

                <dt class="col-sm-3">Phone</dt>
                <dd class="col-sm-9">{{ $store->phone ?? '-' }}</dd>

                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{ $store->address ?? '-' }}</dd>

                <dt class="col-sm-3">Owner</dt>
                <dd class="col-sm-9">{{ $store->owner->name ?? 'N/A' }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
