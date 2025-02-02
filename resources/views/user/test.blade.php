<h1>SINI TEST PAGE </h1>
{{-- <h2>{{ $customer->name }}</h2> --}}

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
        }
    </style>
</head>
<body>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', // Weekly grid view
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'Meeting',
                        start: '2024-12-02T10:30:00',
                        end: '2024-12-02T12:30:00',
                        description: 'Discussion with the team',
                    },
                    {
                        title: 'Lunch Break',
                        start: '2024-12-03T13:00:00',
                        end: '2024-12-03T14:00:00',
                        backgroundColor: '#4682b4',
                        borderColor: '#4682b4',
                        textColor: '#fff',
                    },
                    {
                        title: 'Workshop',
                        start: '2024-12-04T09:00:00',
                        end: '2024-12-04T11:00:00',
                        backgroundColor: '#90ee90',
                    }
                ],
                editable: true, // Enable drag-and-drop
                selectable: true, // Allow selection for new events
                select: function (info) {
                    const title = prompt('Enter event title:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: info.startStr,
                            end: info.endStr,
                            allDay: info.allDay
                        });
                    }
                    calendar.unselect();
                },
                eventClick: function (info) {
                    alert(`Event: ${info.event.title}\nDescription: ${info.event.extendedProps.description || 'No details'}`);
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
