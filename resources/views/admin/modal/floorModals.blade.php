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
