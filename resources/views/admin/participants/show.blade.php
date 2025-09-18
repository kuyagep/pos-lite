@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Participant Details</h1>

        <div class="card rounded-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Participant Info -->
                    <div class="col-md-8">
                        <h4 class="fw-bold text-primary mb-3">
                            <i class="fas fa-user-circle me-2"></i> Participant Information
                        </h4>
                        <p><strong>Full Name:</strong> {{ $participant->full_name }}</p>
                        <p><strong>Employment Type:</strong> {{ $participant->employment_type }}</p>
                        <p><strong>School / Office:</strong> {{ $participant->school_office }}</p>
                        <p><strong>Position:</strong> {{ $participant->position ?? '-' }}</p>
                        <p><strong>Email:</strong> {{ $participant->email ?? '-' }}</p>
                        <p><strong>Contact Number:</strong> {{ $participant->contact_number ?? '-' }}</p>
                        <p><strong>Registered At:</strong> {{ $participant->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <!-- QR Code -->
                    <div class="col-md-4 text-center">
                        <h6 class="fw-bold text-muted mb-2">QR Code</h6>
                        {!! QrCode::size(150)->generate($participant->qr_code) !!}
                        <p class="small text-muted mt-2">{{$participant->qr_code}}</p>
                        <p class="small text-muted mt-2">Scan this QR code for attendance</p>
                    </div>
                </div>
            </div>
        </div>


        <a href="{{ route('admin.participants.index') }}" class="btn btn-deped mt-3 mb-3">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
@endsection
