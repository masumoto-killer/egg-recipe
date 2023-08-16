import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import 'fullcalendar/bootstrap-icons/font/bootstrap-icons.css'

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar.Calendar(calendarEl, {
        events: [
            // Loop through cycle data and create events
            @foreach ($cycles as $cycle)
            {
                title: 'Period',
                start: '{{ $cycle->cycle_start }}',
                end: '{{ $cycle->period_stop }}',
                color: '#4e007a',
            },
            {
                title: 'Ovulation',
                start: '{{ $cycle->ovulation }}',
                color: '#33bbff'
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
            prevYear: 'arrow-left-square-fill',
            nextYear: 'arrow-right-square-fill',
        },
        themeSystem: 'bootstrap5',
        initialView: "dayGridYear",
        locale: 'vi',
        firstDay: '1',
        plugins: [dayGridPlugin],
        plugins: [ bootstrap5Plugin ],
    });
    calendar.render();
});
