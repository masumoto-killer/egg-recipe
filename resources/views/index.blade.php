@extends('app2')

@section('content')
    <div class="container d-flex align-items-start justify-content-center vh-100 mt-4 wrap">
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

                <form action="{{ route('update.cycle') }}" method="post" class="card p-4 my-4">
                    <h2>Update Cycle Information:</h2>
                    @csrf
                    <div class="row mb-4 justify-content-around align-items-center">
                        <div class="form-group col-auto justify-content-lg-center justify-content-md-between justify-content-sm-between align-items-center d-flex">
                            <label for="period_stop" class="col-form-label">Period Stop:</label>
                            <div class="col-7">
                                <input type="date" name="period_stop" class="form-control mx-1">
                            </div>
                        </div>
                        <div class="form-group col-auto justify-content-lg-center justify-content-md-between justify-content-sm-between align-items-center d-flex">
                            <label for="cycle_end" class="col-form-label">Cycle End:</label>
                            <div class="col-7">
                                <input type="date" name="cycle_end" class="form-control mx-1">
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Update Cycle</button>
                    </div>
                </form>

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

                <h2>Last Cycle:</h2>
                <p>Ovulation: {{ $lastCycle->ovulation }}</p>
                <p>Cycle Start: {{ $lastCycle->cycle_start }}</p>
                <p>Period Stop: {{ $lastCycle->period_stop }}</p>
                <p>Cycle End: {{ $lastCycle->cycle_end }}</p>

            </div>
        </div>
    </div>
@endsection
