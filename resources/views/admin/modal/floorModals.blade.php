   <!-- Modal -->
   <div class="modal fade" id="add_floor_modal" tabindex="-1" aria-labelledby="add_floor_modal" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="add_floor_modal">Add Floor level</h1>
               </div>

               <!-- ID in Form -->
               <form id="AddFloorForm" action="{{ route('add_floor_level') }}" method="POST">
                   @csrf
                   <div class="modal-body">

                       <div class="mb-3">
                           <label for="FloorName" class="form-label">Floor Level</label>
                           <input type="text" name="floor_name" class="form-control"
                               placeholder="Enter floor level name" required>
                       </div>

                   </div>
               </form>
               {{-- Id in Button --}}
               <div class="modal-footer" style="padding: 10px;">
                   <button type="submit" class="btn gradient-button" id="AddFloorButton">Add Floor</button>
                   <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
               </div>

           </div>
       </div>
   </div>




   <!-- Update Floor Modal -->
   <div class="modal fade" id="update_floor_modal" tabindex="-1" aria-labelledby="update_floor_modal">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="update_floor_modal">Update Floor Level</h1>
               </div>

               <!-- Update Device Form -->
               <form id="UpdateFloorForm" action="{{ route('floor.update', ':id') }}" method="POST">
                   @csrf
                   @method('PUT')

                   <div class="modal-body">
                       <div class="mb-3">
                           <label for="FloorName" class="form-label">Floor Level</label>
                           <input type="text" id="floor_name" name="floor_name" class="form-control"
                               placeholder="Enter floor level name" required>
                       </div>
                   </div>
               </form>

               <div class="modal-footer" style="padding: 10px;">
                   <button type="submit" class="btn gradient-button" id="UpdateFloorButton">Update Floor</button>
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
                   const floor_name = button.getAttribute('data-floor_name');


                   // Set the values in the modal fields
                   document.getElementById('floor_name').value = floor_name;


                   // Update the form action URL to include the subject ID for the PUT request
                   const form = document.getElementById('UpdateFloorForm');
                   form.action = form.action.replace(':id', id);
               });
           });
       });

       document.getElementById('UpdateFloorButton').addEventListener('click', function() {
           document.getElementById('UpdateFloorForm').submit();
       });
   </script>
