@extends('app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center mt-4">
        <div class="col-md-8">
            <div class="text-center">
                <img src="{{ asset('/logo.png') }}" alt="Logo" width="150" class="py-3">
                <br>
                <h1>Đây là Egg Recipe!</h1>
                <p class="lead">Công cụ giúp bạn quản lý chu kỳ rớt trứng của mình!</p>
                <a href="https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={{ env('GOOGLE_CLIENT_ID') }}&redirect_uri={{ env('GOOGLE_REDIRECT_URI') }}&scope=email%20profile" class="btn btn-primary">Đăng nhập với Google</a>
            </div>
        </div>
    </div>
@endsection
