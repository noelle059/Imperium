 <!-- Header-->
 @include('admin.header')


 <div class="page-content">

     {{-- CLASSROOM --}}
     <div class="page-header">
         <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
             <h2 class="h5 no-margin-bottom">Classroom Monitoring</h2>

             <div style="display: flex; align-items: center;">
                 <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                 <input type="text" id="searchInput" placeholder=" Search..."
                     style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
             </div>
         </div>
     </div>

     <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px;">
         <button class="btn gradient-button" style="display: flex; align-items: center; " type="button"
             data-bs-toggle="modal" data-bs-target="#add_classroom_modal">
             <i class="fa fa-plus" style="margin-right: 5px;"></i> Add Classroom
         </button>
     </div>

     <div class="table-container">
         <table id="uniqueTable" class="styled-table">
             <thead>
                 <tr>
                     <th>Room No.</th>
                     <th>Clssroom Name</th>
                     <th>Floor Level</th>
                     <th>Time</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 <tr class="table-row">
                     <td>1</td>
                     <td>CL1</td>
                     <td>First floor</td>
                     <td>Date and Time</td>
                     <td class="action-cell"><button type="button" class="btn gradient-button">Remote</button></td>
                 </tr>
             </tbody>

         </table>



     </div>



     {{-- INCLUDE CLASSROOM MODALS --}}
     @include('admin.modal.classroomModals')
     @include('admin.sweetAlerts.classroomAlert')

     <!-- Footer-->
     @include('admin.footer')



     <!-- Add your search script below -->
     <script>
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
