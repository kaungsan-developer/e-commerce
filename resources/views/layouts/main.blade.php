<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Store</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts -->
    @stack('css')



</head>

<body>
    <div class="conatiner">
        <nav class="navbar navbar-expand bg-body shadow-sm  d-flex justify-content-between px-3">
            <!-- left side of navbar -->

            <div class="navbar-brand">
                <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#drawer" aria-controls="drawer">
                    <i class="fas fa-bars"></i>
                </button>

                <i class="fa-solid fa-store ms-4 "></i>
                <span class="">Store</span>
            </div>


            <!-- middle side of navbar -->


            <!-- right side of navbar -->

            <div class="navbar-nav d-flex align-items-center flex-nowrap ">
                <li class="nav-item d-none d-lg-inline">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <a href="{{ route('viewAll') }}" class="nav-link">
                        Products
                    </a>
                </li>
                @auth
                    @if (Auth::user()->is_admin)
                        <li class="nav-item d-none d-lg-inline">
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        </li>
                    @endif
                    <li class="nav-item d-flex align-items-center d-none d-lg-inline">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('user.show', Auth::user()) }}">Profile</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>

                    </li>
                    <li class="nav-item position-relative d-none d-lg-inline">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            @if (Auth::user()->cart)
                                <span
                                    class="position-absolute top-10 start-90 translate-middle badge rounded-pill bg-danger">
                                    {{ Auth::user()->cart->products->count() }}
                                </span>
                            @endif
                        </a>
                    </li>


                @endauth
                @guest
                    <li class="nav-item d-none d-lg-inline">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item d-none d-lg-inline">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link" href="#" id="themeToggle"><i class="fa-solid fa-lightbulb fs-5"></i></a>
                </li>
            </div>
        </nav>
    </div>


    </div>
    <div class="container-fluid">
        @yield('content')
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="drawer" aria-labelledby="drawerLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="drawerLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fa-solid fa-house me-2"></i>
                        Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('viewAll') }}" class="nav-link">
                        <i class="fas fa-box me-2"></i>
                        Products
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping me-2"></i>
                            Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.show', Auth::user()) }}">
                            <i class="fa-solid fa-user me-2"></i>
                            {{ Auth::user()->name }}</a>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>
                                Logout</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

</body>


<!--jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@yield('js')
@stack('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.body.setAttribute('data-bs-theme', 'dark');
        } else {
            document.body.setAttribute('data-bs-theme', 'light');
        }
    });

    document.getElementById('themeToggle').addEventListener('click', function() {
        let theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            localStorage.setItem('theme', 'light');
            document.body.setAttribute('data-bs-theme', 'light');
        } else {
            localStorage.setItem('theme', 'dark');
            document.body.setAttribute('data-bs-theme', 'dark');
        }
    });
</script>

</html>
