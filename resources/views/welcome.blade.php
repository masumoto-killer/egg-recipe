@extends('app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="col-md-8">
            <div class="text-center">
                <img src="{{ asset('/logo.jpg') }}" alt="Logo" width="150" class="py-3">
                <br>
                <h1>Welcome to Bloody Circle</h1>
                <p class="lead">Thank you for visiting our site. Login to access exclusive content.</p>
                <a href="https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={{ env('GOOGLE_CLIENT_ID') }}&redirect_uri={{ env('GOOGLE_REDIRECT_URI') }}&scope=email%20profile" class="btn btn-primary">Sign in with Google</a>
            </div>
        </div>
    </div>
@endsection
