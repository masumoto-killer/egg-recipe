@extends('app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mt-5">
                    <h2>User Information:</h2>
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Status: {{ $user->status }}</p>
                    <p>Average Cycle Length: {{ $user->cycle_length }}</p>
                    <p>Average Period Length: {{ $user->period_length }}</p>

                    <h2>Current Cycle Information:</h2>
                    <p>Ovulation: {{ $currentCycle->ovulation }}</p>
                    <p>Cycle Start: {{ $currentCycle->cycle_start }}</p>
                    <p>Period Stop: {{ $currentCycle->period_stop }}</p>
                    <p>Cycle End: {{ $currentCycle->cycle_end }}</p>

                    <h2>Next Cycle Information:</h2>
                    <p>Ovulation: {{ $nextCycle->ovulation }}</p>
                    <p>Cycle Start: {{ $nextCycle->cycle_start }}</p>
                    <p>Period Stop: {{ $nextCycle->period_stop }}</p>
                    <p>Cycle End: {{ $nextCycle->cycle_end }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
