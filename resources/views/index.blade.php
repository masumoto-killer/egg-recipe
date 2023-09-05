@extends('app2')

@section('content')
    <div class="container-fluid d-flex align-items-start justify-content-lg-around justify-content-md-start my-4 flex-wrap">
        <div class="col-lg-8 col-md-12 text-center vh-75">
            <div class="row d-flex flex-wrap">
                <div class="col-md-12 col-lg-7 col-xl-8">
                    <div class="alert alert-warning my-3" role="alert">
                        <h4>Xin chào {{ $user -> name }}</h4>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <h4>{{ $message }}</h4>
                    </div>
                </div>

                <div class="col-md-12 col-lg-5 col-xl-4 py-3">
                    <div class="card mb-3 h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <form action="{{ route('cycle.update', $currentCycle->id) }}" onsubmit="return confirm('Cập nhật chu kỳ?');">
                                @csrf
                                <div class="form-group justify-content-center w-100 <?php if ($user->status == '1' || $user->status == '2') {echo 'd-none';} else {echo 'd-flex flex-wrap';}?>" id="cycle_end_form">
                                    <label for="cycle_end" class="col-form-label">Đã bắt đầu vỡ trứng vào:</label>
                                    <div class="input-group col-auto mx-4">
                                        <input type="date" name="cycle_end" id="cycle_end" class="form-control" value="{{ today()->format('Y-m-d') }}" max="{{ today()->format('Y-m-d') }}">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i></button>
                                    </div>
                                </div>
                                <div class="form-group justify-content-center w-100 <?php if ($user->status == '0' || $user->status == '3') {echo 'd-none';} else {echo 'd-flex flex-wrap';}?>" id="period_stop_form">
                                    <label for="period_stop" class="col-form-label">Đã kết thúc vỡ trứng vào:</label>
                                    <div class="input-group col-auto mx-4">
                                        <input type="date" name="period_stop" id="period_stop" class="form-control" value="{{ today()->format('Y-m-d') }}" max="{{ today()->format('Y-m-d') }}">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <form action="{{ route('update.cycle') }}" method="post" class="card my-4">
                <div class="card-header">{{ ('Cập nhật chu kỳ') }}</div>
                <div class="card-body">
                    @csrf
                    <div class="row justify-content-around align-items-center gy-2">
                        <div class="form-group col-auto justify-content-lg-center justify-content-md-between justify-content-sm-between align-items-center d-flex flex-wrap">
                            <label for="cycle_end" class="col-form-label">Bắt đầu vỡ trứng:</label>
                            <div class="col-auto">
                                <input type="date" name="cycle_end" id="cycle_end" class="form-control mx-1" max="{{ today()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group col-auto justify-content-lg-center justify-content-md-between justify-content-sm-between align-items-center d-flex flex-wrap">
                            <label for="period_stop" class="col-form-label">Kết thúc vỡ trứng:</label>
                            <div class="col-auto">
                                <input type="date" name="period_stop" id="period_stop" class="form-control mx-1" max="{{ today()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-auto mt-4">
                        <button type="submit" class="btn btn-primary" id="update">Cập nhật</button>
                        <script>
                            const updateButton = document.getElementById("update");
                            const dateInput1 = document.getElementById("cycle_end");
                            const dateInput2 = document.getElementById("period_stop");
                            deactivate()
                            
                            function activate() {
                                updateButton.disabled = false;
                            }
                            
                            function deactivate() {
                                updateButton.disabled = true;
                            }

                            function check() {
                                if (dateInput1.value != '' || dateInput2.value != '') {
                                activate()
                                } else {
                                deactivate()
                                }
                            }                            
                            
                            dateInput1.addEventListener('input', check)
                            dateInput2.addEventListener('input', check)
                        </script>
                    </div>
                </div>
            </form> --}}
            <div id="calendar" class="card p-4">
                <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/index.global.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/index.global.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/multimonth/index.global.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5/index.global.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var calendarEl = document.getElementById('calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            themeSystem: 'bootstrap5',
                            initialView: "dayGridMonth",
                            locale: 'vi',
                            timeZone: 'Asia/Tokyo',
                            firstDay: '1',
                            windowResizeDelay: '0',
                            defaultAllDay: false,
                            nextDayThreshold: "09:00:00",
                            displayEventTime: false,
                            dayHeaderFormat: {
                                weekday: 'short',
                            },
                            views: {
                                dayGridMonth: {
                                    titleFormat: {
                                        month: 'numeric',
                                        year: 'numeric',
                                    },
                                },
                                multiMonthYear: {
                                    titleFormat: {
                                        year: "numeric",
                                    },
                                },
                            },
                            buttonText: {
                                month: 'Tháng',
                                year: 'Năm',
                            },
                            buttonIcons: {
                                today: 'bookmark',
                            },
                            headerToolbar: {
                                start: 'dayGridMonth,multiMonthYear',
                                center: 'title',
                                end: 'prev,today,next',
                            },
                            events: [
                                // Loop through cycle data and create events
                                @foreach ($cycles as $cycle)
                                {
                                    title: 'Vỡ trứng',
                                    start: '{{ $cycle->cycle_start }}T12:00:00',
                                    end: '{{ $cycle->period_stop }}T12:00:00',
                                    color: '#ffc2df',
                                    textColor: 'black',
                                },
                                // {
                                //     title: 'Rớt trứng',
                                //     start: '{{ $cycle->ovulation }}',
                                //     color: '#FFF899',
                                //     textColor: 'black',
                                // },
                                @endforeach
                            ],
                        });
                        calendar.render();
                    });
                </script>    
            </div>
        </div>
    </div>
@endsection
