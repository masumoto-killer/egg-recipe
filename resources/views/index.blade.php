@extends('app2')

@section('content')
    <div class="container d-flex align-items-start justify-content-center mt-4 wrap">
        <div class="col-lg-8 col-md-12">
            <div class="text-center">
                <div class="alert alert-info" role="alert">
                    @php
                        $status = $user->status;
                        $currentDate = \Illuminate\Support\Carbon::today();
                        $message = '';
                    @endphp
                    @if($status === '1')
                        @php
                            $daysLeft = \Illuminate\Support\Carbon::parse($currentCycle->period_stop)->diffInDays($currentDate);
                            $message = "Có thể kết thúc hành kinh sau $daysLeft ngày.";
                        @endphp
                    @elseif($status === '3')
                        @php
                            $daysLeft = \Illuminate\Support\Carbon::parse($nextCycle->ovulation)->diffInDays($currentDate);
                            $message = "$daysLeft ngày nữa có thể là ngày rụng trứng";
                        @endphp
                    @elseif($status === '5')
                        @php
                            $daysLeft = \Illuminate\Support\Carbon::parse($nextCycle->cycle_start)->diffInDays($currentDate);
                            $message = "ó thể bắt đầu hành kinh sau $daysLeft ngày.";
                        @endphp
                    @elseif($status === '0')
                        @php
                            $message = "Có thể bắt đầu hành kinh hôm nay";
                        @endphp
                    @elseif($status === '2')
                        @php
                            $message = "Có thể kết thúc hành kinh hôm nay";
                        @endphp
                    @elseif($status === '4')
                        @php
                            $message = "Hôm nay có thể là ngày rụng trứng";
                        @endphp
                    @endif
                        <h2>{{ $message }}</h2>
                </div>

                <form action="{{ route('update.cycle') }}" method="post" class="card my-4">
                    <div class="card-header">{{ ('Cập nhật chu kỳ kinh nguyệt') }}</div>
                    <div class="card-body">
                        @csrf
                        <div class="row justify-content-around align-items-center gy-2">
                            <div class="form-group col-auto justify-content-lg-center justify-content-md-between justify-content-sm-between align-items-center d-flex flex-wrap">
                                <label for="cycle_end" class="col-form-label">Bắt đầu hành kinh:</label>
                                <div class="col-auto">
                                    <input type="date" name="cycle_end" class="form-control mx-1" max="{{ today()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="form-group col-auto justify-content-lg-center justify-content-md-between justify-content-sm-between align-items-center d-flex flex-wrap">
                                <label for="period_stop" class="col-form-label">Kết thúc hành kinh:</label>
                                <div class="col-auto">
                                    <input type="date" name="period_stop" class="form-control mx-1" max="{{ today()->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>
                
                </div>
                <div id="calendar" class="card my-4 p-4">
                    <script src="{{ asset('fullcalendar/core/index.global.js') }}"></script>
                    <script src="{{ asset('fullcalendar/daygrid/index.global.js') }}"></script>
                    <script src="{{ asset('fullcalendar/bootstrap5/index.global.js') }}"></script>
                    <link rel="stylesheet" href="{{ asset('fullcalendar/bootstrap-icons/font/bootstrap-icons.css') }}">
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var calendarEl = document.getElementById('calendar');
                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                events: [
                                    // Loop through cycle data and create events
                                    @foreach ($cycles as $cycle)
                                    {
                                        title: 'Hành kinh',
                                        start: '{{ $cycle->cycle_start }}',
                                        end: '{{ $cycle->period_stop }}',
                                        color: '#ffc2df',
                                        textColor: 'black',
                                    },
                                    {
                                        title: 'Rụng trứng',
                                        start: '{{ $cycle->ovulation }}',
                                        color: '#e9c2ff',
                                        textColor: 'black',
                                    },
                                    @endforeach
                                ],
                                dayHeaderFormat: {
                                    weekday: 'long',
                                },
                                headerToolbar: {
                                    start: 'prevYear',
                                    center: 'title',
                                    end: 'nextYear',
                                },
                                buttonIcons: {
                                    prevYear: 'caret-left-fill',
                                    nextYear: 'caret-right-fill',
                                },
                                themeSystem: 'bootstrap5',
                                initialView: "dayGridYear",
                                locale: 'vi',
                                firstDay: '1',
                                aspectRatio: '1.8',
                                windowResizeDelay: '0',
                            });
                            calendar.render();
                        });
                    </script>    
            </div>
        </div>
    </div>
@endsection
