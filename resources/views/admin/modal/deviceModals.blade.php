   <!-- Modal -->
   <div class="modal fade" id="add_device_modal" tabindex="-1" aria-labelledby="add_device_modal" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="add_device_modal">Add Device</h1>
               </div>

               <!-- ID in Form -->
               <form id="AddDeviceForm" action="{{ route('admin.addDevices') }}" method="POST">
                   @csrf
                   <div class="modal-body">
                       <div class="mb-3">
                           <label for="ClassNo" class="form-label">Classroom No.</label>
                           <input type="number" name="classroom_id" class="form-control"
                               placeholder="Enter Classroom No." required>
                       </div>
                       <div class="mb-3">
                           <label for="DeviceName" class="form-label">Device Name</label>
                           <input type="text" name="device_name" class="form-control" placeholder="Enter device name"
                               required>
                       </div>

                       {{-- <div class="mb-3">
                           <label for="subjectUnits" class="form-label">State of Device</label>
                           <input type="number" name="state" class="form-control" placeholder="Enter units" required>
                       </div> --}}


                   </div>
                   {{-- Id in Button --}}
                   <div class="modal-footer" style="padding: 10px;">
                       <button type="submit" class="btn gradient-button" id="AddDeviceButton">Add Device</button>
                       <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
