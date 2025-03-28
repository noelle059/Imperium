   <!-- Modal -->
   <div class="modal fade" id="add_schedule_modal" tabindex="-1" aria-labelledby="add_schedule_modal" aria-hidden="true">
       <div class="modal-dialog modal-lg" style="max-width:30%;">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="add_schedule_modal">Add Schedule</h1>
               </div>

               <!-- ID in Form -->
               <form id="AddScheduleForm" action="{{ route('add_schedule') }}" method="POST">
                   @csrf
                   <div class="modal-body">

                       <!-- Classroom Name -->
                       <div class="mb-3">
                           <label for="ClassroomName" class="form-label">Classroom Name</label>
                           <select name="classroom_id" class="form-control" required>
                               <option value="" disabled selected>Select Classroom</option>
                               @foreach ($classrooms as $classroom)
                                   <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
                               @endforeach
                           </select>
                       </div>

                       <!-- Professor Name -->
                       <div class="mb-3">
                           <label for="ProfessorName" class="form-label">Professor Name</label>
                           <select name="user_id" class="form-control" required>
                               <option value="" disabled selected>Select Professor</option>
                               @foreach ($users as $professor)
                                   <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                               @endforeach
                           </select>
                       </div>

                       <!-- Subject Name -->
                       <div class="mb-3 position-relative">
                            <label for="SubjectName" class="form-label">Subject Name</label>
                            <input type="text" class="form-control subject_search" placeholder="Search subject..." autocomplete="off">
                            <select name="subject_id" class="form-control mt-2 subject_id" size="5" style="display: none;">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>

                       <!-- Date -->
                       <div class="mb-3">
                           <label for="Date" class="form-label">Date</label>
                           <input type="date" name="date" class="form-control" required>
                       </div>

                       <!-- Start Time -->
                       <div class="mb-3">
                           <label for="StartTime" class="form-label">Start Time</label>
                           <input type="time" name="start_time" class="form-control" required>
                       </div>

                       <!-- End Time -->
                       <div class="mb-3">
                           <label for="EndTime" class="form-label">End Time</label>
                           <input type="time" name="end_time" class="form-control" required>
                       </div>

                   </div>
               </form>

               {{-- Id in Button --}}
               <div class="modal-footer" style="padding: 10px;">
                   <button type="submit" class="btn gradient-button" id="AddScheduleButton">Add Schedule</button>
                   <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
               </div>

           </div>
       </div>
   </div>

   <!-- Update Schedule Modal -->
   <div class="modal fade" id="update_schedule_modal" tabindex="-1" aria-labelledby="update_schedule_modal">
       <div class="modal-dialog modal-lg" style="max-width:30%;">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="update_schedule_modal">Update Schedule</h1>
               </div>

               <form id="UpdateScheduleForm" method="POST">
                   @csrf
                   @method('PUT')

                   <div class="modal-body">

                       <!-- Classroom Name -->
                       <div class="mb-3">
                           <label for="ClassroomName" class="form-label">Classroom Name</label>
                           <select name="classroom_id" id="classroom_id" class="form-control">
                               <option value="" disabled>Select Classroom</option>
                               @foreach ($classrooms as $classroom)
                                   <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
                               @endforeach
                           </select>
                       </div>

                       <!-- Professor Name -->
                       <div class="mb-3">
                           <label for="ProfessorName" class="form-label">Professor Name</label>
                           <select name="user_id" id="user_id" class="form-control">
                               <option value="" disabled selected>Select Professor</option>
                               @foreach ($users as $professor)
                                   <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                               @endforeach
                           </select>
                       </div>

                       <!-- Subject Name -->
                       <div class="mb-3 position-relative">
                            <label for="SubjectName" class="form-label">Subject Name</label>
                            <input type="text" class="form-control subject_search" placeholder="Search subject..." autocomplete="off">
                            <select name="subject_id" class="form-control mt-2 subject_id" size="5" style="display: none;">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>

                       <!-- Date -->
                       <div class="mb-3">
                           <label for="Date" class="form-label">Date</label>
                           <input type="date" name="date" id="schedule_day" class="form-control">
                       </div>

                       <!-- Start Time -->
                       <div class="mb-3">
                           <label for="StartTime" class="form-label">Start Time</label>
                           <input type="time" name="start_time" id="start_time" class="form-control">
                       </div>

                       <!-- End Time -->
                       <div class="mb-3">
                           <label for="EndTime" class="form-label">End Time</label>
                           <input type="time" name="end_time" id="end_time" class="form-control">
                       </div>


                   </div>

               </form>

               <div class="modal-footer" style="padding: 10px;">
                   <button type="button" class="btn gradient-button" id="UpdateScheduleButton">Update
                       Schedule</button>
                   <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
               </div>
           </div>
       </div>
   </div>

<script>
   document.addEventListener("DOMContentLoaded", function () {
    // Function to update modal fields when clicking the edit button
    document.querySelectorAll('[data-bs-target="#update_schedule_modal"]').forEach(button => {
        button.addEventListener('click', function () {
            // Get schedule details from data attributes
            const id = this.getAttribute('data-id');
            const classroom_id = this.getAttribute('data-classroom_id');
            const user_id = this.getAttribute('data-user_id');
            const subject_id = this.getAttribute('data-subject_id');
            const subject_name = this.getAttribute('data-subject_name'); // Add subject name
            const schedule_day = this.getAttribute('data-schedule_day');
            const start_time = this.getAttribute('data-start_time');
            const end_time = this.getAttribute('data-end_time');

            const updateForm = document.getElementById('UpdateScheduleForm');
            updateForm.action = `/admin/update-schedule/${id}`;

            if (document.getElementById('classroom_id')) {
                document.getElementById('classroom_id').value = classroom_id;
            }
            if (document.getElementById('user_id')) {
                document.getElementById('user_id').value = user_id;
            }
            if (document.querySelector('#update_schedule_modal .subject_search')) {
                let subjectSearch = document.querySelector('#update_schedule_modal .subject_search');
                let subjectDropdown = document.querySelector('#update_schedule_modal .subject_id');

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

            if (document.querySelector('.subject_id')) {
                document.querySelector('.subject_id').value = subject_id;
            }
            if (document.getElementById('schedule_day')) {
                document.getElementById('schedule_day').value = schedule_day;
            }
            if (document.getElementById('start_time')) {
                document.getElementById('start_time').value = start_time;
            }
            if (document.getElementById('end_time')) {
                document.getElementById('end_time').value = end_time;
            }

            console.log("Updating Schedule ID:", id);
            console.log("Classroom ID:", classroom_id);
            console.log("Professor ID:", user_id);
            console.log("Subject ID:", subject_id);
            console.log("Subject Name:", subject_name);
            console.log("Schedule Day:", schedule_day);
            console.log("Start Time:", start_time);
            console.log("End Time:", end_time);
        });
    });

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

    // Functionality for subject dropdown search
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
        });

        searchInput.addEventListener("click", function () {
            for (let option of selectDropdown.options) {
                option.style.display = "block";
            }
            selectDropdown.style.display = "block";
        });
    });
});

   </script>

