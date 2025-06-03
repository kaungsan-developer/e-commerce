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


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body data-bs-theme="light">
    <div id="app">
        <nav class="navbar navbar-expand-sm bg-body shadow-sm sticky-top" style="z-index: 100;">
            <div class="container">

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <i class="fas fa-bars fs-5"></i>
                </button>


                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    Store
                </a>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <ul class="navbar-nav me-auto align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index', ['type' => 'all']) }}">Users</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('category.index') }}">Categories</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Add+
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('products.create') }}">
                                        Products
                                    </a>
                                    <a class="dropdown-item" href="{{ route('category.index') }}">
                                        Categories
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.create') }}">
                                        Admin
                                    </a>
                                </div>
                            </li>
                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">

                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('admin.edit', Auth::user()) }}" class="dropdown-item">Setting</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">

                                    Home
                                </a>
                            </li>
                        @endauth
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endguest
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="themeToggle"><i
                                    class="fa-solid fa-lightbulb fs-5"></i></a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>


        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index', ['type' => 'all']) }}">Users</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.index') }}">Categories</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Add+
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('products.create') }}">Products</a></li>

                                <li><a class="dropdown-item" href="{{ route('admin.create') }}">Admin</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">

                                Home
                            </a>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="themeToggle"><i
                                class="fa-solid fa-lightbulb fs-5"></i></a>
                    </li>
                </ul>

            </div>
        </div>


        <main class="py-3" style="position: relative; z-index: 1;">
            @yield('content')
        </main>
    </div>
</body>

@yield('js')

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
