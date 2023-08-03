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

    <div class="container">
        @yield('content')
    </div>

    <!-- Include JS scripts if needed -->
    <script src="{{ asset('bootstrap.js') }}"></script>
</body>
</html>
