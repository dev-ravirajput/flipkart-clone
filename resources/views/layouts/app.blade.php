<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/flipkart-icon.png') }}" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Styles --> 
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: 'Nunito', sans-serif;
        }

        #sidebar-wrapper {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding: 0rem 0;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            padding: 10px 20px;
        }

        .sidebar-nav li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }

        .sidebar-nav li:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        #content-wrapper {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1030;
        }

        .main-content {
            margin-top: 60px; /* Height of the fixed navbar */
            padding: 20px;
        }

        .rounded-circle {
            object-fit: cover;
        }
        .sidebar-nav li.active {
            background-color: #495057;
            color: white;
        }

    .sidebar-nav li a {
        text-decoration: none;
        color: inherit;
        display: block;
        padding: 4px;
    }
    .pr-3{
        padding-right: 0.5rem;
    }
    .card{
        background-color: white;
    }
    /* Show dropdown on hover */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0; /* Adjust this based on your design if needed */
    }

    .dropdown-menu {
        display: none; /* Keep it hidden by default */
    }
    </style>
</head>
<body>
    @if(Auth::user())
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
    <li class="sidebar-brand" style="list-style: none;">
        <img src="{{ asset('img/flipkart.png') }}" alt="Logo" style="width: -webkit-fill-available; height: -webkit-fill-available;">
    </li>
        <ul class="sidebar-nav">
            <li class="{{ Request::routeIs('home') ? 'active' : '' }}"
            ><a href="{{ route('home') }}"><i class="fa-solid fa-house pr-3"></i> Dashboard</a>
        </li>
            <li class="{{ Request::routeIs('admin.products') ? 'active' : '' }}">
                <a href="{{ route('admin.products') }}"><i class="fa-solid fa-box pr-3"></i> Products</a>
            </li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping pr-3"></i> Orders</a></li>
            <li class="{{ Request::routeIs('admin.category') ? 'active' : '' }}">
                <a href="{{ route('admin.category') }}"><i class="fa-solid fa-square-poll-vertical pr-3"></i> Category</a>
            </li>
            <li class="{{ Request::routeIs('admin.subcategory') ? 'active' : '' }}">
                <a href="{{ route('admin.subcategory') }}"><i class="fa-solid fa-list pr-3"></i> Subcategory</a>
            </li>
            <li class="{{ Request::routeIs('admin.brands') ? 'active' : '' }}">
                <a href="{{ route('admin.brands') }}"><i class="fa-solid fa-bolt-lightning pr-3"></i>Brands</a>
            </li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>
    @endif

    <!-- Content Wrapper -->
    <div id="content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
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
                        <li class="nav-item">
                        <li class="nav-item dropdown">
                            <!-- Profile Picture with Hover Dropdown -->
                            <div class="profile-container d-inline-block" style="position: relative;">
                                @if(Auth::user()->profilePic)
                                    <img src="{{ asset('storage/' . Auth::user()->profilePic) }}" alt="Profile Picture" height="50" width="50" class="rounded-circle">
                                @else
                                    <img src="{{ asset('img/man.png') }}" alt="Default Profile Picture" height="50" width="50" class="rounded-circle">
                                @endif

                                <!-- Dropdown menu when hovering over profile picture or name -->
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                        {{ __('View Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <!-- Username with Hover Dropdown -->
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    {{ __('View Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

@if(session('success'))
<script>
    const toastMixin = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    toastMixin.fire({
        animation: true,
        title: '{{ session('success') }}'  
    });
</script>
@endif
</html>
