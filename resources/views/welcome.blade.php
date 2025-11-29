<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>UniSellVie</title>
    
    <!-- Favicon -->
    <link href="{{ asset('template_assets/img/favicon.ico') }}" rel="icon"> 
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template_assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('template_assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" /> 
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template_assets/css/bootstrap.min.css') }}" rel="stylesheet"> 
    
    <!-- Template Stylesheet -->
    <link href="{{ asset('template_assets/css/style.css') }}" rel="stylesheet"> 
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        
        <!-- Sidebar area -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3"> <h3 class="text-primary"></i>UniSellVie</h3>
                </a>
                
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->name ?? 'Guest' }}</h6> <span>{{ Auth::check() ? 'Admin' : 'Guest' }}</span> </div>
                </div>
                
                <div class="navbar-nav w-100">
                    <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fa fa-home me-2"></i>Home</a>
                    @if (Auth::check() && Auth::user()->isSeller())
                        <a href="{{ route('products.index') }}" class="nav-item nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <i class="fa fa-gamepad me-2"></i>Manage Product</a> 
                        <a href="{{ route('platforms.index') }}" class="nav-item nav-link {{ request()->routeIs('platforms.index') ? 'active' : '' }}">
                            <i class="fa fa-desktop me-2"></i>Manage Platform</a> 
                        <a href="{{ route('genres.index') }}" class="nav-item nav-link {{ request()->routeIs('genres.index') ? 'active' : '' }}">
                            <i class="fa fa-tags me-2"></i>Manage Genre</a> 
                    @endif
                    
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="nav-item nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"><i class="fa fa-users me-2"></i>Quản lý Người dùng</a>
                    @endif

                    @auth
                    <div class="nav-item dropdown me-3">
                        <a href="{{ route('cart.index') }}" class="nav-link">
                            <i class="fa fa-shopping-cart"></i>Cart</a>
                    </div>
                    <a href="{{ route('logout') }}" class="nav-item nav-link" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth
                </div>
            </nav>
        </div>
        <!-- End of sidebar area -->

        <!-- Content area -->
        <div class="content">
            <!-- Navigation bar area -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="{{ url('/') }}" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                
                <div class="navbar-nav align-items-center ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="text-white d-none d-lg-inline-flex">{{ Auth::user()->name ?? 'Guest' }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                    <!-- <a href="#" class="dropdown-item">My Profile</a>
                                    <a href="#" class="dropdown-item">Settings</a> -->
                                    <a href="{{ route('orders.index') }}" class="dropdown-item">Order Histories</a>
                                    <a href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </nav>
            <!-- End of navigation bar area -->

            <!-- Footer area -->
            <div class="container-fluid pt-4 px-4">
                @yield('content') </div>
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">UniSellVie</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of footer area -->

        </div>
        <!-- End of content area -->

        <!-- Back to top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template_assets/lib/chart/chart.min.js') }}"></script> 
    <script src="{{ asset('template_assets/lib/easing/easing.min.js') }}"></script> 
    <script src="{{ asset('template_assets/lib/waypoints/waypoints.min.js') }}"></script> 
    <script src="{{ asset('template_assets/lib/owlcarousel/owl.carousel.min.js') }}"></script> 
    <script src="{{ asset('template_assets/lib/tempusdominus/js/moment.min.js') }}"></script> 
    <script src="{{ asset('template_assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script> 
    <script src="{{ asset('template_assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script> 
    
    <!-- Template Javascript -->
    <script src="{{ asset('template_assets/js/main.js') }}"></script> 

</body>

</html>