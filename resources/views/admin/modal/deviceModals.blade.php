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
                           <label for="ClassroomName" class="form-label">Classroom No.</label>
                           <select name="classroom_id" class="form-control" required>
                               <option value="" disabled selected>Select Classroom</option>
                               @foreach ($classrooms as $classroom)
                                   <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
                               @endforeach
                           </select>
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
               </form>
               {{-- Id in Button --}}
               <div class="modal-footer" style="padding: 10px;">
                   <button type="submit" class="btn gradient-button" id="AddDeviceButton">Add Device</button>
                   <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
               </div>

           </div>
       </div>
   </div>





   <!-- Update Device Modal -->
   <div class="modal fade" id="update_device__modal" tabindex="-1" aria-labelledby="update_device__modal">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="update_device__modal">Update Device</h1>
               </div>

               <!-- Update Device Form -->
               <form id="UpdateDeviceForm" action="{{ route('devices.update', ':id') }}" method="POST">
                   @csrf
                   @method('PUT')

                   <div class="modal-body">
                       <div class="mb-3">
                           <label for="device_name" class="form-label">Device Name</label>
                           <input type="text" id="device_name" name="device_name" class="form-control"
                               placeholder="Enter device name" required>
                       </div>


                       <div class="mb-3">
                           <label for="classroom_id" class="form-label">Classroom</label>
                           <select id="classroom_id" name="classroom_id" class="form-control" required>
                               <option value="">Select Classroom</option>
                               @foreach ($classrooms as $classroom)
                                   <option value="{{ $classroom->id }}"
                                       {{ old('classroom_id', $device->classroom_id) == $classroom->id ? 'selected' : '' }}>
                                       {{ $classroom->classroom_name }}
                                   </option>
                               @endforeach
                           </select>
                       </div>



                       <div class="mb-3">
                           <label for="state" class="form-label">State</label>
                           <select id="state" name="state" class="form-control" required>
                               <option value="1">ON</option>
                               <option value="0">OFF</option>
                           </select>
                       </div>
                   </div>
               </form>

               <div class="modal-footer" style="padding: 10px;">
                   <button type="submit" class="btn gradient-button" id="UpdateDeviceButton">Update Device</button>
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
                   const device_name = button.getAttribute('data-device_name');
                   const classroom_id = button.getAttribute('data-classroom_id');
                   const state = button.getAttribute('data-state');

                   // Set the values in the modal fields
                   document.getElementById('device_name').value = device_name;
                   document.getElementById('classroom_id').value = classroom_id;
                   document.getElementById('state').value = state;

                   // Update the form action URL to include the subject ID for the PUT request
                   const form = document.getElementById('UpdateDeviceForm');
                   form.action = form.action.replace(':id', id);
               });
           });
       });

       document.getElementById('UpdateDeviceButton').addEventListener('click', function() {
           document.getElementById('UpdateDeviceForm').submit();
       });
   </script>
