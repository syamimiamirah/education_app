<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            alert('{{ session('success') }}');
                        });
                    </script>
                @endif
                <div class="p-6 mb-3 flex flex-row justify-between items-center">
                    <!-- Search Input and Button -->
                    <div class="flex flex-row w-3/4">
                        <input type="text" id="searchInput" class="full-width-input px-4 py-2 text-sm border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 h-12" placeholder="Search events">
                        <button id="searchButton" class="bg-blue-500 text-white px-4 py-2 border uppercase font-semibold text-xs rounded-r-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 h-12">{{__('Search')}}</button>
                    </div>
                    
                    <!-- Export and Add Buttons -->
                    <div class="flex gap-4 flex-row ml-4">
                        <x-primary-button id="exportButton" class="bg-green-500 border text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 h-12">{{__('Export Calendar')}}</x-primary-button>
                        <a href="{{ route('calendar.create') }}" class="bg-green-500 border font-semibold text-xs text-white uppercase px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 h-12">{{__('Add')}}</a>
                    </div>
                </div>

                <div class="flex">
                    <!-- Calendar Section (3/4) -->
                    <div class="w-3/4 p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <div id="calendar"></div>
                    </div>
                    <!-- Task List Section (1/4) -->
                    <div class="w-1/4 p-6 bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 overflow-y-auto">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Tasks</h3>
                        <ul id="task-list" class="space-y-4">
                            <!-- Tasks will be appended here -->
                            @foreach ($tasks as $task)
                                <li class="bg-white dark:bg-gray-700 shadow-md rounded-md p-4">
                                    <h4 class="text-lg font-semibold">{{ $task->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $task->description }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">From: {{ $task->start_date }} To: {{ $task->end_date }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Status: {{ $task->status }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .full-width-input {
        flex-grow: 1;
        width: 0; /* This helps to ensure the input grows to fill the available space */
    }
 
    /* General text color */
    #calendar .fc-event-title,
    #calendar .fc-daygrid-event-dot,
    #calendar .fc-event-time,
    #calendar .fc-event-title-container,
    #calendar .fc-list-event-title,
    #calendar .fc-list-event-time,
    #calendar .fc-list-event-dot,
    #calendar .fc-event-main,
    #calendar .fc-timegrid-slot-label,
    #calendar .fc-timegrid-axis-cushion {
        color: white !important;
    }

    /* Calendar header text color */
    #calendar .fc-toolbar-title,
    #calendar .fc-button,
    #calendar .fc-button-active,
    #calendar .fc-button-primary,
    #calendar .fc-button-primary:disabled,
    #calendar .fc-button-primary:not(:disabled):focus,
    #calendar .fc-button-primary:not(:disabled):hover,
    #calendar .fc-button-primary:not(:disabled):active,
    #calendar .fc-button-primary:not(:disabled).fc-button-primary--is-clicked {
        color: white !important;
    }

    /* Day headers (e.g., Sun, Mon) */
    #calendar .fc-col-header-cell-cushion {
        color: white !important;
    }

    /* Date numbers */
    #calendar .fc-daygrid-day-number,
    #calendar .fc-daygrid-day-top {
        color: white !important;
    }

    /* Event background color (optional) */
    #calendar .fc-event,
    #calendar .fc-event-dot {
        background-color: #4a5568 !important; /* Adjust the background color as needed */
        border-color: #4a5568 !important; /* Match the border color to the background */
    }

    </style>
    <!-- Include FullCalendar -->
     
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendarEl = document.getElementById('calendar');
        var events = [];
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialView: 'dayGridMonth',
            timeZone: 'UTC',
            events: '/events',
            editable: true,

            dateClick: function(info) {
                var selectedDate = info.dateStr; // Get the selected date in YYYY-MM-DD format
                fetchTasksForDate(selectedDate);
            },


            // Deleting The Event
            eventContent: function(info) {
                var eventTitle = info.event.title;
                var eventElement = document.createElement('div');
                eventElement.innerHTML = '<span style="cursor: pointer;">❌</span> ' + eventTitle;

                eventElement.querySelector('span').addEventListener('click', function() {
                    if (confirm("Are you sure you want to delete this event?")) {
                        var eventId = info.event.id;
                        $.ajax({
                            method: 'get',
                            url: '/schedule/delete/' + eventId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log('Event deleted successfully.');
                                calendar.refetchEvents(); // Refresh events after deletion
                            },
                            error: function(error) {
                                console.error('Error deleting event:', error);
                            }
                        });
                    }
                });
                return {
                    domNodes: [eventElement]
                };
            },

            // Drag And Drop

            eventDrop: function(info) {
                var eventId = info.event.id;
                var newStartDate = info.event.start;
                var newEndDate = info.event.end || newStartDate;
                var newStartDateUTC = newStartDate.toISOString().slice(0, 10);
                var newEndDateUTC = newEndDate.toISOString().slice(0, 10);

                $.ajax({
                    method: 'post',
                    url: `/schedule/${eventId}`,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        start_date: newStartDateUTC,
                        end_date: newEndDateUTC,
                    },
                    success: function() {
                        console.log('Event moved successfully.');
                    },
                    error: function(error) {
                        console.error('Error moving event:', error);
                    }
                });
            },

            // Event Resizing
            eventResize: function(info) {
                var eventId = info.event.id;
                var newEndDate = info.event.end;
                var newEndDateUTC = newEndDate.toISOString().slice(0, 10);

                $.ajax({
                    method: 'post',
                    url: `/schedule/${eventId}/resize`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        end_date: newEndDateUTC
                    },
                    success: function() {
                        console.log('Event resized successfully.');
                    },
                    error: function(error) {
                        console.error('Error resizing event:', error);
                    }
                });
            },
        });

        calendar.render();

        document.getElementById('searchButton').addEventListener('click', function() {
            var searchKeywords = document.getElementById('searchInput').value.toLowerCase();
            filterAndDisplayEvents(searchKeywords);
        });

        function filterAndDisplayEvents(searchKeywords) {
            $.ajax({
                method: 'GET',
                url: `/events/search?title=${searchKeywords}`,
                success: function(response) {
                    calendar.removeAllEvents();
                    calendar.addEventSource(response);
                },
                error: function(error) {
                    console.error('Error searching events:', error);
                }
            });
        }

        // Exporting Function
        document.getElementById('exportButton').addEventListener('click', function() {
            var events = calendar.getEvents().map(function(event) {
                return {
                    title: event.title,
                    start: event.start ? event.start.toISOString() : null,
                    end: event.end ? event.end.toISOString() : null,
                    color: event.backgroundColor,
                };
            });

            var wb = XLSX.utils.book_new();

            var ws = XLSX.utils.json_to_sheet(events);

            XLSX.utils.book_append_sheet(wb, ws, 'Events');

            var arrayBuffer = XLSX.write(wb, {
                bookType: 'xlsx',
                type: 'array'
            });

            var blob = new Blob([arrayBuffer], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            var downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(blob);
            downloadLink.download = 'events.xlsx';
            downloadLink.click();
        });
    </script>
</x-app-layout>
