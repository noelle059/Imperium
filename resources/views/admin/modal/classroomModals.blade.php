  <!-- Classroom Modal -->
  <div class="modal fade" id="add_classroom_modal" tabindex="-1" aria-labelledby="add_classroom_modal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="add_classroom_modal">Add Classroom</h1>
              </div>

              <!-- ID in Form -->
              <form id="AddClassroomForm" action="{{ route('add_classroom') }}" method="POST">
                  @csrf
                  <div class="modal-body">

                      <div class="mb-3">
                          <label for="ClassName" class="form-label">Classroom Name</label>
                          <input type="text" name="classroom_name" class="form-control"
                              placeholder="Enter Classroom  name" required>
                      </div>

                      <div class="mb-3">
                          <label for="FloorName" class="form-label ">Floor Level</label>
                          <select name="floor_id" class="form-control" required>
                              <option value="" disabled selected>Select Floor Level</option>
                              @foreach ($floors as $floor)
                                  <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                              @endforeach
                          </select>
                      </div>


                  </div>
              </form>
              {{-- Id in Button --}}
              <div class="modal-footer" style="padding: 10px;">
                  <button type="submit" class="btn gradient-button" id="AddClassroomButton">Add Classroom</button>
                  <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
              </div>

          </div>
      </div>
  </div>





  <!-- Update  Modal -->
  <div class="modal fade" id="update_classroom_modal" tabindex="-1" aria-labelledby="update_classroom_modal">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="update_classroom_modal">Update Classroom</h1>
              </div>

              <!-- Update Device Form -->
              <form id="UpdateClassroomForm" action="{{ route('update_classroom', ':id') }}" method="POST">
                  @csrf
                  @method('PUT')

                  <div class="modal-body">
                      <div class="mb-3">
                          <label for="ClassName" class="form-label">Classroom Name</label>
                          <input type="text" id="classroom_name" name="classroom_name" class="form-control"
                              placeholder="Enter Classroom  name" required>
                      </div>

                      <div class="mb-3">
                          <label for="FloorName" class="form-label">Floor Level</label>
                          <select name="floor_id" id="floor_id" class="form-control" required>
                              <option value="" disabled selected>Select Floor Level</option>
                              @foreach ($floors as $floor)
                                  <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                              @endforeach
                          </select>
                      </div>

                  </div>
              </form>

              <div class="modal-footer" style="padding: 10px;">
                  <button type="submit" class="btn gradient-button" id="UpdateClassroomButton">Update
                      Classroom</button>
                  <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
              </div>
          </div>

      </div>
  </div>




  <script>
      // JavaScript to populate modal fields when the update button is clicked
      document.addEventListener('DOMContentLoaded', function() {
          const updateButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

          updateButtons.forEach(button => {
              button.addEventListener('click', function() {
                  const id = button.getAttribute('data-id');
                  const classroom_name = button.getAttribute('data-classroom_name');
                  const floor_id = button.getAttribute('data-floor_id');


                  // Set the values in the modal fields
                  document.getElementById('classroom_name').value = classroom_name;
                  document.getElementById('floor_id').value = floor_id;


                  // Update the form action URL to include the subject ID for the PUT request
                  const form = document.getElementById('UpdateClassroomForm');
                  form.action = form.action.replace(':id',
                      id); // Ensure that the :id placeholder is replaced with the actual id
              });
          });
      });

      // Confirm before submitting the form
      document.getElementById('UpdateClassroomButton').addEventListener('click', function(event) {
          event.preventDefault(); // Prevent the form submission immediately

          // Get the current value of floor_name
          const classroom_name = document.getElementById('classroom_name')
              .value; // Get the value from the input field

          // Extract the floor ID from the form action (assuming the action URL has the correct floor ID)
          const ClassroomID = document.getElementById('UpdateClassroomForm').action.split('/').pop();

          // Check if floor name is empty for debugging
          console.log('Classroom Name:', classroom_name); // Debugging line to check if floorName has a value

          // If floor name is empty, alert the user to fill the field
          if (!classroom_name) {
              Swal.fire({
                  title: 'Error',
                  text: 'Please enter a classroom name.',
                  icon: 'error',
                  confirmButtonText: 'OK'
              });
              return; // Stop execution if floor name is missing
          }

          // If all fields are filled, show the confirmation dialog
          Swal.fire({
              title: 'Are you sure?',
              text: `Do you want to update the classroom: ${classroom_name}?`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, Update Classroom',
              cancelButtonText: 'Cancel',
              reverseButtons: true,
          }).then((result) => {
              if (result.isConfirmed) {
                  // If confirmed, update the form action dynamically with the floor ID (in case it hasn't been updated already)
                  const formAction =
                      `/admin/update-classroom/${ClassroomID}`; // Update URL for the specific floor
                  document.getElementById('UpdateClassroomForm').action = formAction;

                  // Submit the form after confirmation
                  document.getElementById('UpdateClassroomForm').submit(); // Submit the form
              }
          });
      });
  </script>
