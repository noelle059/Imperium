 <!-- Header-->
 @include('admin.header')


 <div class="page-content">

     {{-- FLOOR --}}
     <div class="page-header">
         <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
             <h2 class="h5 no-margin-bottom">Archived Floor Building</h2>

             <div style="display: flex; align-items: center;">
                 <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                 <input type="text" id="searchInput" placeholder=" Search..."
                     style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
             </div>
         </div>
     </div>


     <div class="table-container">
         <table id="uniqueTable" class="styled-table">
             <thead>
                 <tr>
                     <th> No.</th>
                     <th>Floor Level</th>
                     <th>Room Count</th>
                     <th>Entry Date</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($archiveFloors as $floor)
                     <tr class="table-row">
                         <td>{{ $loop->iteration }}</td>
                         <td>{{ $floor->floor_name }}</td>
                         <td>{{ $floor->classrooms_count }} <!-- This will display the room count for the floor -->
                         </td>

                         <td>{{ \Carbon\Carbon::parse($floor->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}
                         </td>


                         <td class="action-cell">

                             <!-- Removing the subject from the list -->
                             <button class="btn gradient-button retrieve" type="button" data-id="{{ $floor->id }}"
                                 id="RetrieveFloortButton">
                                 <i class="fa-solid fa-trash-can-arrow-up"></i>

                             </button>
                         </td>

                     </tr>
                 @endforeach

             </tbody>

         </table>
     </div>





     {{-- INCLUDE ADMIN MODAL AND ALERT --}}
     @include('admin.sweetAlerts.archiveAlert')


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
