@extends('app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mt-5">
                    <img src="{{ asset('path/to/your/logo.png') }}" alt="Logo" width="150">
                    <h1 class="mt-4">Welcome to Your Website</h1>
                    <p class="lead">Thank you for visiting our site. Login to access exclusive content.</p>
                    <a href="https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={{ env('GOOGLE_CLIENT_ID') }}&redirect_uri={{ env('GOOGLE_REDIRECT_URI') }}&scope=email%20profile" class="btn btn-primary">Sign in with Google</a>
                </div>
            </div>
        </div>
    </div>
@endsection
