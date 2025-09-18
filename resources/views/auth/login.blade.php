<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - My POS System</title>

    <!-- SB Admin 2 -->
    <link href="{{ asset('static/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('static/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom overrides -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body class="bg-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-7 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h1 class="h4 text-gray-900 mb-2">Welcome Back!</h1>
                                    <p class="mb-4">Login to access your POS Dashboard</p>
                                </div>

                                <!-- Login Form -->
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="email" aria-describedby="emailHelp"
                                               placeholder="Enter Email Address..."
                                               value="{{ old('email') }}" required autofocus>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password" placeholder="Password" required>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                            <label class="custom-control-label" for="remember">Remember Me</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>

                                <hr>

                                <!-- Links -->
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if (Route::has('register'))
                                        <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('static/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('static/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('static/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('static/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
