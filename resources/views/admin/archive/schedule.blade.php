@include('admin.header')
{{-- CSS ADD --}}



<!-- Account-->
<div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Schedule Monitoring</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>



    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Classroom</th>
                    <th>Professor Assigned</th>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Start-Time</th>
                    <th>End-Time</th>
                    <th>Schedule added on</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archiveSchedules as $index => $schedule)
                    <tr class="table-row">
                        <td>{{ $index + 1 }}</td> <!-- Auto-increment number -->
                        <td>{{ $schedule->classroom->classroom_name ?? 'N/A' }}</td> <!-- Classroom name -->
                        <td>{{ $schedule->user->name ?? 'N/A' }}</td> <!-- Professor (User) name -->
                        <td>{{ $schedule->subject->subject_name ?? 'N/A' }}</td> <!-- Subject name -->
                        <td>{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('l') }}</td>
                        <!-- Day of the week -->
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td> <!-- Start time -->
                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td> <!-- End time -->
                        <td>{{ \Carbon\Carbon::parse($schedule->created_at)->format('M d, Y') }}</td>
                        <!-- Entry Date -->
                        <td class="action-cell">
                            <!-- Removing the subject from the list -->
                            <button class="btn gradient-button retrieve" type="button" data-id="{{ $schedule->id }}"
                                id="RetrieveScheduleButton">
                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="pagination" style="margin-top: 20px">
            {{ $archiveSchedules->links() }}
        </div>
    </div>

    {{-- INCLUDE ADMIN MODAL AND ALERT --}}
    @include('admin.sweetAlerts.archiveAlert')




    {{-- INCLUDE FOOTER --}}
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
