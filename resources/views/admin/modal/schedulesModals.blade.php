<!-- Add Schedule Modal -->
<div class="modal fade" id="add_schedule_modal" tabindex="-1" aria-labelledby="add_schedule_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add_schedule_modal_title">Add Schedule</h1>
            </div>

            <form id="AddScheduleForm" action="{{ route('add_schedule') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Classroom Name -->
                    <div class="mb-3">
                        <label for="add_classroom_id" class="form-label">Classroom Name</label>
                        <select name="classroom_id" id="add_classroom_id" class="form-control" required>
                            <option value="" disabled selected>Select Classroom</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
                            @endforeach
                        </select>
                        <span id="classroom_id_error" class="text-danger"></span>
                    </div>

                    <!-- Professor Name -->
                    <div class="mb-3">
                        <label for="add_user_id" class="form-label">Professor Name</label>
                        <select name="user_id" id="add_user_id" class="form-control" required>
                            <option value="" disabled selected>Select Professor</option>
                            @foreach ($users as $professor)
                                <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Name -->
                    <div class="mb-3 position-relative">
                        <label for="add_subject_search" class="form-label">Subject Name</label>
                        <input type="text" id="add_subject_search" class="form-control subject_search" placeholder="Search subject..." autocomplete="off">
                        <select name="subject_id" id="add_subject_id" class="form-control mt-2 subject_id" size="5" style="display: none;">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="add_units" class="form-label">Units</label>
                        <input type="text" id="add_units" class="form-control units" readonly>
                    </div>

                    <!-- Schedule Day -->
                    <div class="mb-3">
                        <label for="add_schedule_day" class="form-label">Schedule Day</label>
                        <select name="schedule_day" id="add_schedule_day" class="form-control" required>
                            <option value="" disabled selected>Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                        <span id="schedule_day_error" class="text-danger"></span>
                    </div>

                    <!-- Start Time -->
                    <div class="mb-3">
                        <label for="add_start_time" class="form-label">Start Time</label>
                        <input type="time" name="start_time" id="add_start_time" class="form-control" required>
                        <span id="start_time_error" class="text-danger"></span>
                    </div>

                </div>

                <div class="modal-footer" style="padding: 10px;">
                    <button type="submit" class="btn gradient-button" id="AddScheduleButton">Add Schedule</button>
                    <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Schedule Modal -->
<div class="modal fade" id="update_schedule_modal" tabindex="-1" aria-labelledby="update_schedule_modal">
   <div class="modal-dialog modal-lg" style="max-width:30%;">
       <div class="modal-content">
           <div class="modal-header">
               <h1 class="modal-title fs-5" id="update_schedule_modal_title">Update Schedule</h1>
           </div>

           <form id="UpdateScheduleForm" method="POST">
               @csrf
               @method('PUT')

               <div class="modal-body">
                   <!-- Classroom Name -->
                   <div class="mb-3">
                       <label for="update_classroom_id" class="form-label">Classroom Name</label>
                       <select name="classroom_id" id="update_classroom_id" class="form-control" required>
                           <option value="" disabled>Select Classroom</option>
                           @foreach ($classrooms as $classroom)
                               <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
                           @endforeach
                       </select>
                       <span id="update_classroom_id_error" class="text-danger"></span>
                   </div>

                   <!-- Professor Name -->
                   <div class="mb-3">
                       <label for="update_user_id" class="form-label">Professor Name</label>
                       <select name="user_id" id="update_user_id" class="form-control" required>
                           <option value="" disabled selected>Select Professor</option>
                           @foreach ($users as $professor)
                               <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                           @endforeach
                       </select>
                       <span id="update_user_id_error" class="text-danger"></span>
                   </div>

                   <!-- Subject Name -->
                   <div class="mb-3 position-relative">
                        <label for="update_subject_search" class="form-label">Subject Name</label>
                        <input type="text" id="update_subject_search" class="form-control subject_search" placeholder="Search subject..." autocomplete="off">
                        <select name="subject_id" id="update_subject_id" class="form-control mt-2 subject_id" size="5" style="display: none;" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                        <span id="update_subject_id_error" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="update_units" class="form-label">Units</label>
                        <input type="text" id="update_units" class="form-control units" readonly>
                    </div>

                   <!-- Schedule Day -->
                   <div class="mb-3 position-relative">
                        <label for="update_schedule_day" class="form-label">Schedule Day</label>
                        <select name="schedule_day" id="update_schedule_day" class="form-control" required>
                            <option value="" disabled selected>Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                        <span id="update_schedule_day_error" class="text-danger"></span>
                    </div>

                   <!-- Start Time -->
                   <div class="mb-3">
                       <label for="update_start_time" class="form-label">Start Time</label>
                       <input type="time" name="start_time" id="update_start_time" class="form-control" required>
                       <span id="update_start_time_error" class="text-danger"></span>
                   </div>
               </div>

               <div class="modal-footer" style="padding: 10px;">
                   <button type="submit" class="btn gradient-button" id="UpdateScheduleButton">Update Schedule</button>
                   <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
               </div>
           </form>
       </div>
   </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Calculate end time function
    function calculateEndTime(startTimeInput, unitsInput) {
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

            let endTimeField = startTimeInput.closest("form").querySelector("[name='end_time']");
            if (!endTimeField) {
                endTimeField = document.createElement("input");
                endTimeField.type = "hidden";
                endTimeField.name = "end_time";
                startTimeInput.closest("form").appendChild(endTimeField);
            }
            endTimeField.value = formattedEndTime;
        }
    }

    // Register event handlers for Add Schedule
    const addStartTimeInput = document.getElementById("add_start_time");
    const addUnitsInput = document.getElementById("add_units");

    if (addStartTimeInput && addUnitsInput) {
        addStartTimeInput.addEventListener("change", function() {
            calculateEndTime(addStartTimeInput, addUnitsInput);
        });

        addUnitsInput.addEventListener("change", function() {
            calculateEndTime(addStartTimeInput, addUnitsInput);
        });
    }

    // Register event handlers for Update Schedule
    const updateStartTimeInput = document.getElementById("update_start_time");
    const updateUnitsInput = document.getElementById("update_units");

    if (updateStartTimeInput && updateUnitsInput) {
        updateStartTimeInput.addEventListener("change", function() {
            calculateEndTime(updateStartTimeInput, updateUnitsInput);
        });

        updateUnitsInput.addEventListener("change", function() {
            calculateEndTime(updateStartTimeInput, updateUnitsInput);
        });
    }

    // Event Delegation: Fetch and update units dynamically
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("subject_id")) {
            let subjectId = event.target.value;
            let form = event.target.closest("form");
            let unitsInput = form ? form.querySelector(".units") : null;

            if (subjectId && unitsInput) {
                fetch(`/get-subject-units/${subjectId}`)
                    .then(response => response.json())
                    .then(data => {
                        unitsInput.value = data.units !== null ? data.units : "";
                        // Calculate end time with the correct input elements
                        let startTimeInput = form.querySelector("[name='start_time']");
                        if (startTimeInput) {
                            calculateEndTime(startTimeInput, unitsInput);
                        }
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

    // Update modal fields when clicking the edit button
    document.querySelectorAll('[data-bs-target="#update_schedule_modal"]').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const classroom_id = this.getAttribute('data-classroom_id');
            const user_id = this.getAttribute('data-user_id');
            const subject_id = this.getAttribute('data-subject_id');
            const updateUnits = this.getAttribute('data-subject-units');
            const subject_name = this.getAttribute('data-subject_name');
            const schedule_day = this.getAttribute('data-schedule_day');
            const start_time = this.getAttribute('data-start_time');
            const end_time = this.getAttribute('data-end_time');

            const updateForm = document.getElementById('UpdateScheduleForm');
            updateForm.action = `/admin/update-schedule/${id}`;

            // Update form fields with unique IDs
            if (document.getElementById('update_classroom_id')) {
                document.getElementById('update_classroom_id').value = classroom_id;
            }
            if (document.getElementById('update_user_id')) {
                document.getElementById('update_user_id').value = user_id;
            }

            // Set the subject
            if (document.getElementById('update_subject_search')) {
                let subjectSearch = document.getElementById('update_subject_search');
                let subjectDropdown = document.getElementById('update_subject_id');

                subjectSearch.value = subject_name;
                subjectSearch.setAttribute('data-selected-value', subject_id);
                subjectSearch.dispatchEvent(new Event('input', { bubbles: true }));

                if (subjectDropdown) {
                    subjectDropdown.value = subject_id;
                    let optionToSelect = subjectDropdown.querySelector(`option[value="${subject_id}"]`);
                    if (optionToSelect) {
                        optionToSelect.selected = true;
                    }
                }
            }

            if (document.getElementById('update_units')) {
                document.getElementById('update_units').value = updateUnits;
            }

            // Set the schedule day
            if (document.getElementById('update_schedule_day')) {
                document.getElementById('update_schedule_day').value = schedule_day;
            }

            // Set the start time
            if (document.getElementById('update_start_time')) {
                document.getElementById('update_start_time').value = start_time.slice(0, 5);
            }

            // Calculate end time based on updated values
            calculateEndTime(
                document.getElementById('update_start_time'),
                document.getElementById('update_units')
            );

            console.log("Updating Schedule ID:", id);
        });
    });

    // Reset all fields when Add Schedule modal is opened
    $('#add_schedule_modal').on('show.bs.modal', function () {
        const form = document.getElementById('AddScheduleForm');
        if (form) {
            form.reset();

            // Clear specific fields
            if (document.getElementById('add_subject_search')) {
                document.getElementById('add_subject_search').value = '';
            }
            if (document.getElementById('add_units')) {
                document.getElementById('add_units').value = '';
            }

            // Reset any errors
            const errorSpans = form.querySelectorAll('.text-danger');
            errorSpans.forEach(span => span.textContent = '');
        }
    });

    // Confirmation prompt before updating schedule
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

    // Subject dropdown search functionality - separate for each modal
    function setupSubjectSearch(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const searchInput = modal.querySelector(".subject_search");
        const selectDropdown = modal.querySelector(".subject_id");

        if (!searchInput || !selectDropdown) return;

        searchInput.addEventListener("focus", function () {
            selectDropdown.style.display = "block";
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
        });

        searchInput.addEventListener("click", function () {
            for (let option of selectDropdown.options) {
                option.style.display = "block";
            }
            selectDropdown.style.display = "block";
        });
    }

    // Setup subject search for each modal separately
    setupSubjectSearch("add_schedule_modal");
    setupSubjectSearch("update_schedule_modal");

    // Close dropdowns when clicking outside
    document.addEventListener("click", function (event) {
        // For add modal
        const addSearchInput = document.getElementById("add_subject_search");
        const addSelectDropdown = document.getElementById("add_subject_id");

        if (addSearchInput && addSelectDropdown &&
            !addSearchInput.contains(event.target) &&
            !addSelectDropdown.contains(event.target)) {
            addSelectDropdown.style.display = "none";
        }

        // For update modal
        const updateSearchInput = document.getElementById("update_subject_search");
        const updateSelectDropdown = document.getElementById("update_subject_id");

        if (updateSearchInput && updateSelectDropdown &&
            !updateSearchInput.contains(event.target) &&
            !updateSelectDropdown.contains(event.target)) {
            updateSelectDropdown.style.display = "none";
        }
    });
});
</script>
