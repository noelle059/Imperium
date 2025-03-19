   <!-- Modal -->
   <div class="modal fade" id="add_schedule_modal" tabindex="-1" aria-labelledby="add_schedule_modal" aria-hidden="true">
       <div class="modal-dialog modal-lg">
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
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="update_schedule_modal">Update Schedule</h1>
               </div>

               <!-- Update Schedule Form -->
               <form id="UpdateScheduleForm" action="{{ route('update_schedule', ':id') }}" method="POST">
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
       // Format time to HH:mm
       function formatTime(time) {
           let date = new Date('1970-01-01T' + time + 'Z'); // Create a date object from the time string
           let hours = date.getUTCHours().toString().padStart(2, '0');
           let minutes = date.getUTCMinutes().toString().padStart(2, '0');
           return hours + ':' + minutes; // Return in HH:mm format
       }

       // Event listener for buttons that trigger modal
       document.querySelectorAll('[data-bs-target="#update_schedule_modal"]').forEach(button => {
           button.addEventListener('click', function() {
               const id = this.getAttribute('data-id'); // Get schedule ID
               const classroom_id = this.getAttribute('data-classroom_id');
               const user_id = this.getAttribute('data-user_id');
               const subject_id = this.getAttribute('data-subject_id');
               const schedule_day = this.getAttribute('data-schedule_day'); // Date value
               const start_time = this.getAttribute('data-start_time'); // Start time value
               const end_time = this.getAttribute('data-end_time'); // End time value

               // Update the form action to include the schedule ID
               const formAction = `/admin/update-schedule/${id}`;
               document.getElementById('UpdateScheduleForm').action = formAction;

               // Populate the modal fields with the current values
               document.getElementById('classroom_id').value = classroom_id;
               document.getElementById('user_id').value = user_id;
               document.getElementById('subject_id').value = subject_id;
               document.getElementById('schedule_day').value = schedule_day; // Set the date

               // Format and set the start and end times (ensure HH:mm format)
               document.getElementById('start_time').value = formatTime(start_time); // Set the start time
               document.getElementById('end_time').value = formatTime(end_time); // Set the end time

               // Log current values to the console
               console.log('Current Classroom ID:', classroom_id);
               console.log('Current Professor ID:', user_id);
               console.log('Current Subject ID:', subject_id);
               console.log('Current Schedule Day:', schedule_day);
               console.log('Current Start Time:', start_time);
               console.log('Current End Time:', end_time);
           });
       });

       // Update Schedule Button click handler
       document.getElementById('UpdateScheduleButton').addEventListener('click', function(event) {
           event.preventDefault(); // Prevent form submission initially

           // Show confirmation dialog before submitting the form
           Swal.fire({
               title: 'Are you sure?',
               text: `Do you want to update the schedule?`,
               icon: 'warning',
               showCancelButton: true,
               confirmButtonText: 'Yes, Update Schedule',
               cancelButtonText: 'Cancel',
               reverseButtons: true,
           }).then((result) => {
               if (result.isConfirmed) {
                   // If confirmed, submit the form
                   document.getElementById('UpdateScheduleForm').submit();
               }
           });
       });
   </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
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
                    option.style.display = "block"; // kung ano lang nag match na text sa option, yun lang lalabas
                    hasResults = true;
                } else {
                    option.style.display = "none"; // kung walang match na text sa option, walang lalabas na option
                }
            }

            selectDropdown.style.display = hasResults ? "block" : "none"; // matik pag walang match na text sa option, matatanggal dapat yung dropdown
        });

        selectDropdown.addEventListener("change", function () {
            searchInput.value = selectDropdown.options[selectDropdown.selectedIndex].text;
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
