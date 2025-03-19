<!-- Header-->
@include('admin.header')


<div class="page-content">

    {{-- CLASSROOM --}}
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Archived Classroom </h2>

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
                    <th>Room No.</th>
                    <th>Clssroom Name</th>
                    <th>Device Count</th>
                    <th>Floor Level</th>
                    <th>Entry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archiveClassrooms as $index => $classroom)
                    <tr class="table-row">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $classroom->classroom_name }}</td>

                        <td>{{ $classroom->devices_count }}</td> <!-- This will display the device count -->

                        <td>{{ $classroom->floor ? $classroom->floor->floor_name : 'N/A' }}</td>
                        <!-- Display floor_name -->


                        <td>{{ \Carbon\Carbon::parse($classroom->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}
                        </td>

                        <td class="action-cell">

                            <!-- Removing the subject from the list -->
                            <button class="btn gradient-button retrieve" type="button" data-id="{{ $classroom->id }}"
                                id="RetrieveClassroomtButton">
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
