<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Bloody Circle') }}</title>
    <!-- Include CSS and other meta tags -->
    <link rel="stylesheet" href="{{ asset('bootstrap.css') }}">
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
