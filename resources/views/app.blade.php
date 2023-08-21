<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Egg Recipe') }}</title>
    <!-- Include CSS and other meta tags -->
    <link rel="stylesheet" href="{{ asset('bootstrap.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;700&family=Tilt+Neon&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Add your navigation bar or header content here -->
    <nav class="navbar navbar-expand-sm navbar-light bg-light px-5">
        <div class="container-fluid">
            <div class="navbar-brand mb-0 h1" href="">
                <img src="{{ asset('/logo.png') }}" alt="Logo" height="60" class="px-2">Egg Recipe
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
