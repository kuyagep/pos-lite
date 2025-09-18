<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,  shrink-to-fit=no">
    <title>POSLite - Smart & Simple POS for Small Businesses</title>

    <!-- Meta Description -->
    <meta name="description" content="POSLite helps sari-sari stores, coffee shops, and small restos manage sales, inventory, and reports with ease.">

    <!-- Keywords -->
    <meta name="keywords" content="POS System, Inventory, Sari-sari store POS, Coffee shop POS, Restaurant POS, Sales tracking">

    <!-- Author -->
    <meta name="author" content="POSLite">

    <!-- Open Graph (for Facebook, LinkedIn, etc.) -->
    <meta property="og:title" content="POSLite - Smart POS for Small Businesses">
    <meta property="og:description" content="Easily manage sales, inventory, and reports with POSLite. Designed for sari-sari stores, coffee shops, and small restaurants.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/og-preview.png') }}"> <!-- Create this preview image -->

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="POSLite - Smart POS for Small Businesses">
    <meta name="twitter:description" content="POS + Inventory system for sari-sari stores, coffee shops, and restaurants.">
    <meta name="twitter:image" content="{{ asset('images/og-preview.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link href="{{ asset('static/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom overrides -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Smart POSLite</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="btn btn-light text-primary ml-3" href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="fw-bold">Welcome to POSLite</h1>
            <p class="lead">Smart, Simple, and Efficient Point of Sale for your business</p>
            <a href="#features" class="btn btn-light text-primary btn-lg mt-3">Get Started</a>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-cash-register fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Easy Sales</h5>
                            <p class="card-text">Record and manage sales seamlessly with our intuitive POS interface.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Inventory Tracking</h5>
                            <p class="card-text">Stay on top of your stock with real-time inventory alerts and reports.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Analytics</h5>
                            <p class="card-text">View daily reports and best-selling products to make smarter decisions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Pricing Plans</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">Starter</div>
                        <div class="card-body">
                            <h3 class="card-title">$9/mo</h3>
                            <ul class="list-unstyled">
                                <li>Basic Features</li>
                                <li>1 Cashier</li>
                                <li>Email Support</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Choose</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">Pro</div>
                        <div class="card-body">
                            <h3 class="card-title">$29/mo</h3>
                            <ul class="list-unstyled">
                                <li>All Starter Features</li>
                                <li>5 Cashiers</li>
                                <li>Reports & Analytics</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Choose</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">Enterprise</div>
                        <div class="card-body">
                            <h3 class="card-title">$99/mo</h3>
                            <ul class="list-unstyled">
                                <li>Unlimited Features</li>
                                <li>Unlimited Cashiers</li>
                                <li>24/7 Support</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Choose</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Contact Us</h2>
            <p class="mb-3">Have questions? Reach out and we’ll be happy to help.</p>
            <a href="mailto:support@mpos.com" class="btn btn-primary">Email Support</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <small>© {{ date('Y') }} My POS System. All Rights Reserved.</small>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('static/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('static/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('static/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('static/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
