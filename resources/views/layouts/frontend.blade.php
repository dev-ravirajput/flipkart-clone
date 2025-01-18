<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Flipkart') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/flipkart-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <header>
<nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('main.home') }}">
          <img src="{{ asset('img/flipkart-plus_white.png') }}" alt="Flipkart Logo">
        </a>

        <!-- Hamburger Icon -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Menu -->
        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('main.home') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact</a>
            </li>
          </ul>
          <div class="search-bar">
            <input type="text" name="search" placeholder="Search here">
            <button>Search</button>
          </div>
          <div class="nav-icons d-flex align-items-center mx-2">
            <a href="cart.html"><i class="fas fa-shopping-cart"></i></a>
            <div class="dropdown">
              <a href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                @if(Auth::user())
                <li><a class="dropdown-item" href="{{ route('login') }}">Profile</a></li>
                @else
                <li><a class="dropdown-item" href="{{ route('login') }}">Sign In</a></li>
                <li><a class="dropdown-item" href="{{ route('register') }}">Sign Up</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main>
    @yield('content')
  </main>
  <footer>
    <p>&copy; {{ date('Y') }} MyWeb.com</p>
  </footer>
</body>
</html>
