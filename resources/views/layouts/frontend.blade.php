<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Flipkart') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/flipkart-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="{{ asset('img/flipkart-plus_white.png') }}" alt="Flipkart Logo">
            </div>
            <ul class="nav-links">
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
            <div class="search-bar">
                <input class="form-control" type="text" name="search" id="search" placeholder="Search here">
                <button class="btn search-btn">Search</button>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer all-center">
        <p>&copy; {{ date('Y') }} MyWeb.com</p>
    </footer>
</body>
</html>
