@extends('app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mt-5">
                    <h2>User Profile:</h2>
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Status: {{ $user->status }}</p>
                    <p>Average Cycle Length: {{ $user->cycle_length }}</p>
                    <p>Average Period Length: {{ $user->period_length }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
