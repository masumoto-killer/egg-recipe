@extends('app2')

@section('content')
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="col-md-8">
            <div class="text-center">
                @php
                    $status = $user->status;
                    $currentDate = \Illuminate\Support\Carbon::today();
                    $message = '';
                @endphp
                @if($status === 'In Period')
                @php
                    $daysLeft = \Illuminate\Support\Carbon::parse($currentCycle->period_stop)->diffInDays($currentDate);
                    $message = "This period may end after $daysLeft days.";
                @endphp
            @elseif($status === 'Before Ovulation')
                @php
                    $daysLeft = \Illuminate\Support\Carbon::parse($nextCycle->ovulation)->diffInDays($currentDate);
                    $message = "An ovulation may come after $daysLeft days.";
                @endphp
            @elseif($status === 'Before Period')
                @php
                    $daysLeft = \Illuminate\Support\Carbon::parse($nextCycle->cycle_start)->diffInDays($currentDate);
                    $message = "The next period may start after $daysLeft days.";
                @endphp
            @elseif($status === 'Period Start')
                @php
                    $message = "A period may start today.";
                @endphp
            @elseif($status === 'Period End')
                @php
                    $message = "This period may end today.";
                @endphp
            @elseif($status === 'Ovulation')
                @php
                    $message = "An ovulation may come today.";
                @endphp
            @endif
                <div class="alert alert-info" role="alert">
                    {{ $message }}
                </div>

                <h2>Current Cycle:</h2>
                <p>Ovulation: {{ $currentCycle->ovulation }}</p>
                <p>Cycle Start: {{ $currentCycle->cycle_start }}</p>
                <p>Period Stop: {{ $currentCycle->period_stop }}</p>
                <p>Cycle End: {{ $currentCycle->cycle_end }}</p>

                <h2>Next Cycle:</h2>
                <p>Ovulation: {{ $nextCycle->ovulation }}</p>
                <p>Cycle Start: {{ $nextCycle->cycle_start }}</p>
                <p>Period Stop: {{ $nextCycle->period_stop }}</p>
                <p>Cycle End: {{ $nextCycle->cycle_end }}</p>
            </div>
        </div>
    </div>
@endsection
