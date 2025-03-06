 <!-- Add Subject Modal -->
 <div class="modal fade" id="add_subject_modal" tabindex="-1" aria-labelledby="add_subject_modal">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="add_subject_modal">Add Subject</h1>
             </div>

             <!-- Add suject Form -->
             <form id="AddSubjectForm" action="{{ route('subjects.store') }}" method="POST">
                 @csrf
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="subjectCode" class="form-label">Subject Code</label>
                         <input type="text" name="subject_code" class="form-control" placeholder="Enter subject code"
                             required>
                     </div>
                     <div class="mb-3">
                         <label for="subjectName" class="form-label">Subject Name</label>
                         <input type="text" name="subject_name" class="form-control" placeholder="Enter subject name"
                             required>
                     </div>
                     <div class="mb-3">
                         <label for="subjectUnits" class="form-label">Units</label>
                         <input type="number" name="subject_units" class="form-control" placeholder="Enter units"
                             required>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn gradient-button" id="AddSubjectButton">Add Subject</button>
                     <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
                 </div>
             </form>

         </div>
     </div>
 </div>




 <!-- Update Subject Modal -->
 <div class="modal fade" id="update_subject_modal" tabindex="-1" aria-labelledby="update_subject_modal">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="update_subject_modal">Update Subject</h1>
             </div>

             <!-- Update Subject Form -->
             <form id="UpdateSubjectForm" action="{{ route('subjects.update', ':id') }}" method="POST">
                 @csrf
                 @method('PUT')

                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="subjectCode" class="form-label">Subject Code</label>
                         <input type="text" id="subject_code" name="subject_code" class="form-control"
                             placeholder="Enter subject code" required>
                     </div>
                     <div class="mb-3">
                         <label for="subjectName" class="form-label">Subject Name</label>
                         <input type="text" id="subject_name" name="subject_name" class="form-control"
                             placeholder="Enter subject name" required>
                     </div>
                     <div class="mb-3">
                         <label for="subjectUnits" class="form-label">Units</label>
                         <input type="number" id="subject_units" name="subject_units" class="form-control"
                             placeholder="Enter units" required>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn gradient-button" id="UpdateSubjectButton">Update Subject</button>
                     <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <script>
     // JavaScript to populate modal fields when the update button is clicked
     document.addEventListener('DOMContentLoaded', function() {
         const updateButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

         updateButtons.forEach(button => {
             button.addEventListener('click', function() {
                 const subjectId = button.getAttribute('data-id');
                 const subjectCode = button.getAttribute('data-subject_code');
                 const subjectName = button.getAttribute('data-subject_name');
                 const subjectUnits = button.getAttribute('data-subject_units');

                 // Set the values in the modal fields
                 document.getElementById('subject_code').value = subjectCode;
                 document.getElementById('subject_name').value = subjectName;
                 document.getElementById('subject_units').value = subjectUnits;

                 // Update the form action URL to include the subject ID for the PUT request
                 const form = document.getElementById('UpdateSubjectForm');
                 form.action = form.action.replace(':id', subjectId);
             });
         });
     });
 </script>
