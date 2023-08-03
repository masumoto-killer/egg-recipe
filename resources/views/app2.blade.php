<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Bloody Circle') }}</title>
    <!-- Include CSS and other meta tags -->
    <link rel="stylesheet" href="{{ asset('bootstrap.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;700&family=Tilt+Neon&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Add your navigation bar or header content here -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">Logo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <!-- Add more navbar items here -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>

    <!-- Include JS scripts if needed -->
    <script src="{{ asset('bootstrap.js') }}"></script>
</body>
</html>
