@extends('app2')

@section('content')
    <div class="container-md d-flex align-items-start justify-content-lg-around justify-content-md-start my-4 flex-wrap">
        <div class="col-lg-4 col-md-12 text-center">
            <div class="alert alert-warning" role="alert">
                <h4>Xin chào {{ $user -> name }}</h4>
            </div>

            <div class="alert alert-info" role="alert">
                <h4>{{ $message }}</h4>
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
        </div>

        <div class="col-lg-6 col-md-12 text-center">                
            <div id="calendar" class="card p-4">
                    <script>
                        import { Calendar } from '@fullcalendar/core'
                        import dayGridPlugin from '@fullcalendar/daygrid'
                        import multiMonthPlugin from '@fullcalendar/multimonth'
                        import bootstrap5Plugin from '@fullcalendar/bootstrap5';
                        document.addEventListener('DOMContentLoaded', function () {
                            var calendarEl = document.getElementById('calendar');
                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                plugins: [dayGridPlugin, multiMonthPlugin, bootstrap5Plugin],
                                events: [
                                    // Loop through cycle data and create events
                                    @foreach ($cycles as $cycle)
                                    {
                                        title: 'Vỡ trứng',
                                        start: '{{ $cycle->cycle_start }}',
                                        end: '{{ $cycle->period_stop }}',
                                        color: '#ffc2df',
                                        textColor: 'black',
                                    },
                                    {
                                        title: 'Rớt trứng',
                                        start: '{{ $cycle->ovulation }}',
                                        color: '#FFF899',
                                        textColor: 'black',
                                    },
                                    @endforeach
                                ],
                                dayHeaderFormat: {
                                    weekday: 'short',
                                },
                                titleFormat: {
                                    month: 'numeric',
                                    year: 'numeric',
                                },
                                buttonText: {
                                    today: 'Hôm nay',
                                },
                                // monthStartFormat: {
                                //     month: 'short',
                                //     day: 'numeric',
                                // },
                                headerToolbar: {
                                    start: 'today,dayGridMonth,multiMonthYear',
                                    center: 'title',
                                    end: 'prev,next',
                                },
                                // buttonIcons: {
                                //     prevYear: 'caret-left-fill',
                                //     nextYear: 'caret-right-fill',
                                // },
                                themeSystem: 'bootstrap5',
                                initialView: "dayGridMonth",
                                locale: 'vi',
                                firstDay: '1',
                                windowResizeDelay: '0',
                                height: 'auto',
                            });
                            calendar.render();
                        });
                    </script>    
            </div>
        </div>
    </div>
@endsection
