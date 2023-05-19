<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bloody Circle</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>

        </style>
    </head>
    <body>
        <a href="https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={{ env('GOOGLE_CLIENT_ID') }}&redirect_uri=http://localhost:8000/auth/google/callback&scope=email%20profile">Sign in with Google</a>
    </body>
</html>
