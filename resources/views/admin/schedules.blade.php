<!-- schedules.blade.php -->
@include('admin.header')
{{-- CSS ADD --}}

<!-- Account-->
<div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Schedule Monitoring</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>


    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px;">
        <button class="btn gradient-button calendar" style="display: flex; align-items: center;" type="button"
                data-bs-toggle="modal" data-bs-target="#view_calendar_modal">
            <i class="fa fa-calendar" style="margin-right: 5px;"></i>
        </button>


        <button class="btn gradient-button add" style="display: flex; align-items: center;" type="button"
                data-bs-toggle="modal" data-bs-target="#add_schedule_modal">
            <i class="fa fa-plus" style="margin-right: 5px;"></i>
        </button>
    </div>


    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Classroom</th>
                    <th>Professor Assigned</th>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Start-Time</th>
                    <th>End-Time</th>
                    <th>Schedule added on</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $index => $schedule)
                    <tr class="table-row">
                        <td>{{ $index + 1 }}</td> <!-- Auto-increment number -->
                        <td>{{ $schedule->classroom->classroom_name ?? 'N/A' }}</td> <!-- Classroom name -->
                        <td>{{ $schedule->user->name ?? 'N/A' }}</td> <!-- Professor (User) name -->
                        <td>{{ $schedule->subject->subject_name ?? 'N/A' }}</td> <!-- Subject name -->
                        <td>{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('l') }}</td>
                        <!-- Day of the week -->
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td> <!-- Start time -->
                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td> <!-- End time -->
                        <td>{{ \Carbon\Carbon::parse($schedule->created_at)->format('M d, Y') }}</td>
                        <!-- Entry Date -->
                        <td class="action-cell">
                            <!-- Updating Schedule -->
                            <button class="btn gradient-button update" type="button" data-id="{{ $schedule->id }}"
                                data-classroom_id="{{ $schedule->classroom_id }}"
                                data-user_id="{{ $schedule->user_id }}" data-subject_id="{{ $schedule->subject_id }}"
                                data-subject_name="{{ $schedule->subject->subject_name }}"
                                data-subject-units="{{ $schedule->subject->units }}"
                                data-schedule_day="{{ $schedule->schedule_day }}"
                                data-start_time="{{ $schedule->start_time }}"
                                data-bs-toggle="modal"
                                data-bs-target="#update_schedule_modal">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </button>

                            <!-- Removing Schedule -->
                            <button class="btn gradient-button archive" type="button" data-id="{{ $schedule->id }}"
                                data-schedule_day="{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('Y-m-d') }}"
                                data-start_time="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                                data-end_time="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}"
                                id="RemoveScheduleButton">
                                <i class="fa-solid fa-box-archive"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="pagination" style="margin-top: 20px">
            {{ $schedules->links() }}
        </div>
    </div>

    {{-- INCLUDE ADMIN MODAL AND ALERT --}}
    @include('admin.modal.schedulesModals')
    @include('admin.modal.calendarModal')
    @include('admin.sweetAlerts.scheduleAlert')


    {{-- INCLUDE FOOTER --}}
    @include('admin.footer')


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startTimeInput = document.querySelector("[name='start_time']");
        const unitsInput = document.getElementById("units") || document.getElementById("update_units");

        document.addEventListener("input", function (event) {
            if (event.target.matches("[name='start_time'], #update_units, #units")) {
                calculateEndTime();
            }
        });

        if (startTimeInput && unitsInput) {
            startTimeInput.addEventListener("change", calculateEndTime);
            unitsInput.addEventListener("change", calculateEndTime);

            function calculateEndTime() {
                let startTimeInput = document.querySelector("[name='start_time']");
                let unitsInput = document.getElementById("units") || document.getElementById("update_units");

                if (!startTimeInput || !unitsInput) {
                    console.error("Missing input fields for start time or units.");
                    return; // Stop execution if fields are not found
                }

                let startTime = startTimeInput.value;
                let units = parseFloat(unitsInput.value);

                if (startTime && !isNaN(units) && units > 0) {
                    let [hours, minutes] = startTime.split(":").map(Number);
                    hours += units;

                    let endTime = new Date();
                    endTime.setHours(hours, minutes);

                    let formattedEndTime = endTime.toTimeString().slice(0, 5);

                    let endTimeField = document.querySelector("[name='end_time']");
                    if (!endTimeField) {
                        endTimeField = document.createElement("input");
                        endTimeField.type = "hidden";
                        endTimeField.name = "end_time";
                        startTimeInput.closest("form").appendChild(endTimeField);
                    }
                    endTimeField.value = formattedEndTime;
                }
            }
        }

        // Event Delegation: Fetch and update units dynamically for both Add & Update modals
        document.addEventListener("change", function (event) {
            if (event.target.classList.contains("subject_id")) {
                let subjectId = event.target.value;
                let modal = event.target.closest(".modal");
                let unitsInput = modal ? modal.querySelector("#units, #update_units") : null;

                if (subjectId && unitsInput) {
                    fetch(`/get-subject-units/${subjectId}`)
                        .then(response => response.json())
                        .then(data => {
                            unitsInput.value = data.units !== null ? data.units : "";
                            calculateEndTime(); // Recalculate end time when units change
                        })
                        .catch(error => {
                            console.error("Error fetching subject units:", error);
                            unitsInput.value = "";
                        });
                } else if (unitsInput) {
                    unitsInput.value = "";
                }
            }
        });

        // Common function to check for schedule conflicts - works for both add and update
        function checkForConflicts(formId, errorPrefix = '') {
            const form = document.getElementById(formId);
            if (!form) return;

            const classroomId = form.querySelector('[name="classroom_id"]').value;
            const scheduleDay = form.querySelector('[name="schedule_day"]').value;
            const startTime = form.querySelector('[name="start_time"]').value;
            const professorId = form.querySelector('[name="user_id"]').value;
            const scheduleId = form.getAttribute('data-schedule-id') || '';
            const subjectId = form.querySelector('[name="subject_id"]').value;

            // Check if required fields are filled
            if (!classroomId || !scheduleDay || !startTime || !professorId) {
                return; // Exit if any required field is empty
            }

            // Make an AJAX request to check for conflicts
            let url = `/check-schedule-conflict?classroom_id=${classroomId}&schedule_day=${scheduleDay}&start_time=${startTime}&professor_id=${professorId}&subject_id=${subjectId}`;

            // Add schedule ID for update operations to exclude the current schedule from conflict checks
            if (scheduleId) {
                url += `&schedule_id=${scheduleId}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Clear previous error messages
                    document.getElementById(`${errorPrefix}classroom_id_error`).textContent = '';
                    document.getElementById(`${errorPrefix}schedule_day_error`).textContent = '';
                    document.getElementById(`${errorPrefix}start_time_error`).textContent = '';

                    let errors = false;

                    // Display errors based on the server response
                    if (data.error) {
                        if (data.message.classroom) {
                            document.getElementById(`${errorPrefix}classroom_id_error`).textContent = data.message.classroom;
                            errors = true;
                        }
                        if (data.message.schedule) {
                            document.getElementById(`${errorPrefix}schedule_day_error`).textContent = data.message.schedule;
                            errors = true;
                        }
                        if (data.message.time) {
                            document.getElementById(`${errorPrefix}start_time_error`).textContent = data.message.time;
                            errors = true;
                        }
                    }

                    // Disable or enable submit button based on validation
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = errors;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.querySelectorAll('#add_schedule_modal input, #add_schedule_modal select, #add_schedule_modal .subject_search').forEach(element => {
            element.addEventListener('change', function() {
                checkScheduleConflicts('add');
            });
        });

        document.querySelectorAll('#update_schedule_modal input, #update_schedule_modal select, #update_schedule_modal .subject_search').forEach(element => {
            element.addEventListener('change', function() {
                checkScheduleConflicts('update');
            });
        });

        // Setup the add schedule modal validation
        $('#add_schedule_modal').on('shown.bs.modal', function () {
            const form = document.getElementById('AddScheduleForm');
            if (!form) return;

            form.addEventListener('input', function(event) {
                if (event.target.name === 'classroom_id' || event.target.name === 'schedule_day' ||
                    event.target.name === 'start_time' || event.target.name === 'user_id') {
                    checkForConflicts('AddScheduleForm', '');
                }
            });
        });

        // Setup the update schedule modal validation
        $('#update_schedule_modal').on('shown.bs.modal', function () {
            const form = document.getElementById('UpdateScheduleForm');
            if (!form) return;

            form.addEventListener('input', function(event) {
                if (event.target.name === 'classroom_id' || event.target.name === 'schedule_day' ||
                    event.target.name === 'start_time' || event.target.name === 'user_id') {
                    checkForConflicts('UpdateScheduleForm', 'update_');
                }
            });

            // Trigger initial validation when modal opens (to catch any conflicts with the current values)
            checkForConflicts('UpdateScheduleForm', 'update_');
        });

        // Reset error messages and enable submit buttons when modals are closed
        $('#add_schedule_modal, #update_schedule_modal').on('hidden.bs.modal', function () {
            const modalId = this.id;
            const prefix = modalId === 'update_schedule_modal' ? 'update_' : '';
            const formId = modalId === 'update_schedule_modal' ? 'UpdateScheduleForm' : 'AddScheduleForm';
            const form = document.getElementById(formId);

            if (form) {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = false;
                }

                // Clear all error messages
                document.getElementById(`${prefix}classroom_id_error`).textContent = '';
                document.getElementById(`${prefix}schedule_day_error`).textContent = '';
                document.getElementById(`${prefix}start_time_error`).textContent = '';
            }
        });

        // Update modal fields when clicking the edit button
        document.querySelectorAll('[data-bs-target="#update_schedule_modal"]').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const classroom_id = this.getAttribute('data-classroom_id');
                const user_id = this.getAttribute('data-user_id');
                const subject_id = this.getAttribute('data-subject_id');
                const subject_units = this.getAttribute('data-subject-units');
                const subject_name = this.getAttribute('data-subject_name');
                const schedule_day = this.getAttribute('data-schedule_day');
                const start_time = this.getAttribute('data-start_time');

                console.log("Updating Schedule - Data loaded:", {
                    id, classroom_id, user_id, subject_id, subject_units, subject_name, schedule_day, start_time
                });

                const updateForm = document.getElementById('UpdateScheduleForm');
                updateForm.action = `/admin/update-schedule/${id}`;
                updateForm.setAttribute('data-schedule-id', id);

                // Set the classroom_id
                const classroomSelect = updateForm.querySelector('[name="classroom_id"]');
                if (classroomSelect) {
                    classroomSelect.value = classroom_id;
                }

                // Set the user_id (professor)
                const userSelect = updateForm.querySelector('[name="user_id"]');
                if (userSelect) {
                    userSelect.value = user_id;
                }

                // Set the subject
                const subjectSearch = updateForm.querySelector('.subject_search');
                const subjectSelect = updateForm.querySelector('[name="subject_id"]');

                if (subjectSearch && subjectSelect) {
                    subjectSearch.value = subject_name;
                    subjectSelect.value = subject_id;

                    // Make the selection visible
                    const selectedOption = subjectSelect.querySelector(`option[value="${subject_id}"]`);
                    if (selectedOption) {
                        selectedOption.selected = true;
                    }
                }

                // Set the units
                const unitsInput = document.getElementById('update_units');
                if (unitsInput) {
                    unitsInput.value = subject_units;
                }

                // Set the schedule day
                const daySelect = updateForm.querySelector('[name="schedule_day"]');
                if (daySelect) {
                    daySelect.value = schedule_day;
                }

                // Set the start time
                const startTimeInput = updateForm.querySelector('[name="start_time"]');
                if (startTimeInput) {
                    // Ensure we have the correct format (HH:MM)
                    startTimeInput.value = start_time.includes(':') ? start_time.slice(0, 5) : start_time;
                }

                // Calculate end time based on these values
                calculateEndTime();
            });
        });

        // Convert the UpdateScheduleButton to use the form submit rather than direct AJAX
        document.getElementById('UpdateScheduleButton').addEventListener('click', function (event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to update the schedule?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Update Schedule",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('UpdateScheduleForm').submit();
                }
            });
        });

        // Subject dropdown search functionality
        document.querySelectorAll(".modal").forEach((modal) => {
            const searchInput = modal.querySelector(".subject_search");
            const selectDropdown = modal.querySelector(".subject_id");

            if (!searchInput || !selectDropdown) return;

            searchInput.addEventListener("focus", function () {
                selectDropdown.style.display = "block";
            });

            document.addEventListener("click", function (event) {
                if (!searchInput.contains(event.target) && !selectDropdown.contains(event.target)) {
                    selectDropdown.style.display = "none";
                }
            });

            searchInput.addEventListener("input", function () {
                const filter = searchInput.value.toLowerCase();
                const options = selectDropdown.getElementsByTagName("option");

                let hasResults = false;
                for (let option of options) {
                    let text = option.textContent.toLowerCase();
                    if (text.includes(filter) || option.value === "") {
                        option.style.display = "block";
                        hasResults = true;
                    } else {
                        option.style.display = "none";
                    }
                }

                selectDropdown.style.display = hasResults ? "block" : "none";
            });

            selectDropdown.addEventListener("change", function () {
                searchInput.value = selectDropdown.options[selectDropdown.selectedIndex].text;
                searchInput.setAttribute('data-selected-value', selectDropdown.value);
                selectDropdown.style.display = "none";

                // Trigger validation on subject change
                if (modal.id === 'add_schedule_modal') {
                    checkForConflicts('AddScheduleForm', '');
                } else if (modal.id === 'update_schedule_modal') {
                    checkForConflicts('UpdateScheduleForm', 'update_');
                }
            });

            searchInput.addEventListener("click", function () {
                for (let option of selectDropdown.options) {
                    option.style.display = "block";
                }
                selectDropdown.style.display = "block";
            });
        });
    });
    // DOM CONTENT LOADED END
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let table = document.getElementById('uniqueTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let matchFound = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        let cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(filter) > -1) {
                            matchFound = true;
                        }
                    }
                }

                if (matchFound) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    </script>



    {{-- //BUTTON HOVER UPDATE --}}
    <style>
        /* Tooltip container */
        .update:hover::after {
            content: "Click to update";
            /* Tooltip text */
            position: absolute;
            top: -30px;
            /* Position above the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* Ensure the button is positioned correctly */
        .btn {
            position: relative;
        }
    </style>


    {{-- BUTTON HOVER ARCHIVE --}}
    <style>
        /* Tooltip container */
        .archive:hover::after {
            content: "Click to archive";
            /* Tooltip text */
            position: absolute;
            top: -30px;
            /* Position above the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* Ensure the button is positioned correctly */
        .btn {
            position: relative;
        }
    </style>


    {{-- // BUTTON HOVER ADD --}}
    <style>
        /* Tooltip container */
        .add:hover::after {
            content: "Click to add";
            /* Tooltip text */
            position: absolute;
            top: -30px;
            /* Position above the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .calendar:hover::after { /* For calendar to nakilagay lang */
            content: "Click to view calendar";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        #calendar {
            width: 100%;
            max-width: 100%;
            height: auto;
            min-height: 450px;
            margin: 0 auto;
            padding: 10px;
            overflow: hidden;
        }

        .modal-dialog {
            max-width: 90%;
            width: auto !important;
        }

        .modal-content {
            display: flex;
            flex-direction: column;
            height: auto;
        }


        #fc-dom-1{
            color: white;
        }


        /* Ensure the button is positioned correctly */
        .btn {
            position: relative;
        }

        /* Remove hover effect when the button is disabled */
        button:disabled,
        button[disabled] {
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.5;
        }

        /* Optional: Remove the hover effect when the button is disabled */
        button:disabled:hover {
            background-color: initial; /* Remove the hover background color */
            color: initial; /* Remove the hover text color */
        }

        /* Ensure the button is not clickable or hovered */
        button:disabled {
            cursor: not-allowed;
        }
    </style>
