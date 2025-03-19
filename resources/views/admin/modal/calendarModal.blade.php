<!-- Calendar Modal -->
<div class="modal fade" id="view_calendar_modal" tabindex="-1" aria-labelledby="view_calendar_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="view_calendar_modal">Calendar for Class Schedule</h1>
            </div>

            <div class="modal-body">
                <div id="calendar"></div>
            </div>

            <div class="modal-footer" style="padding: 10px;">
                <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.fc-theme-standard .fc-scrollgrid {
    background-color: rgba(240, 240, 240, 0.99);
}

.fc .fc-toolbar {
    background: #d5a432;
    color: white;
    padding: 10px;
    border-radius: 5px;
}

.fc .fc-button {
    background: #d5a432 !important;
    border: none !important;
    color: white !important;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    transition: background 0.3s;
}

.fc .fc-button:hover {
    background: #4caf50 !important;
}

.fc .fc-button-active {
    background: #47773f !important;
}

.fc-event {
    background: #4caf50 !important;
    border: none !important;
    color: white !important;
    font-size: 14px;
    padding: 5px;
    border-radius: 5px;
}

.fc-event-title, .fc-event-time {
    color: white !important;
}

.fc-event:hover::after {
    content: "Click for details";
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333333;
    color: white;
    padding: 5px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
}
</style>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            let calendarEl = document.getElementById("calendar");
            let calendar;

            function initializeCalendar() {
                if (!calendar) {
                    calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: "dayGridMonth",
                        headerToolbar: {
                            left: "prev,next today",
                            center: "title",
                            right: "dayGridMonth,timeGridWeek,timeGridDay"
                        },
                        events: async function (fetchInfo, successCallback, failureCallback) {
                            try {
                                let response = await fetch("/get-schedules");
                                let data = await response.json();

                                console.log("Fetched Schedules:", data);

                                let events = data.map(schedule => ({
                                    id: schedule.id,
                                    title: schedule.title,
                                    start: schedule.start,
                                    end: schedule.end,
                                    allDay: schedule.allDay,
                                    extendedProps: schedule.extendedProps
                                }));

                                console.log("Formatted Events for FullCalendar:", events);

                                successCallback(events);
                            } catch (error) {
                                console.error("Error fetching schedules:", error);
                                failureCallback(error);
                            }
                        },
                        eventContent: function(arg) {
                            let startTime = formatTime(arg.event.start);
                            let endTime = formatTime(arg.event.end);
                            let floorName = arg.event.extendedProps.floor;
                            return {
                                html: `
                                    <div style="white-space: normal;">
                                        <b>${startTime} to ${endTime}</b> <br>
                                        <b><span>${floorName}</span></b>
                                        <span>${arg.event.title}</span>
                                    </div>
                                `
                            };
                        },
                        eventClick: function (info) {
                            let event = info.event.extendedProps;

                            Swal.fire({
                                title: info.event.title,
                                html: `
                                    ${event.floor} <br>
                                    <b>Subject:</b> ${event.subject} <br>
                                    <b>Professor:</b> ${event.professor} <br>
                                    <b>Registered Time:</b> ${event.registered_time}
                                `,
                                icon: "info"
                            });
                        }
                    });
                }

                setTimeout(() => {
                    calendar.render();
                }, 300);
            }

            function formatTime(date) {
                let options = { hour: "numeric", minute: "2-digit", hour12: true };
                return new Date(date).toLocaleTimeString("en-US", options);
            }

            document.getElementById("view_calendar_modal").addEventListener("shown.bs.modal", initializeCalendar);
        });

    </script>
