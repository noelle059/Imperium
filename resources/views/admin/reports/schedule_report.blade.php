@include('admin.header')

<div class="page-content">
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Classroom Report</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>

                <!-- Room Search -->
                <label for="searchRoom"></label>
                <input type="text" id="searchRoom" placeholder="Enter Room Name">
                <!-- Start Date -->
                <label for="searchInputStart">Start</label>
                <input type="date" id="searchInputStart">

                <!-- End Date -->
                <label for="searchInputEnd">End</label>
                <input type="date" id="searchInputEnd">
            </div>
        </div>
    </div>

<style>

.btn.gradient-button {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
}

.btn.gradient-button i {
    font-size: 18px;
}

.btn.gradient-button::after {
    content: "";
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

.btn.gradient-button:hover::after {
    opacity: 1;
}

.print-button:hover::after {
    content: "Print";
}

.print-all-button:hover::after {
    content: "Print All";
}

</style>
    

    <div style="display: flex; justify-content: flex-end; margin-top: 10px; padding-right: 20px;">
        <a href="#" onclick="printAll()" class="btn gradient-button print-button print-all-button">
            <i class="fa-solid fa-file-pdf"></i> 
        </a>
    </div>

    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Classroom</th>
                    <th>Professor</th>
                    <th>Subject</th>
                    <th>RFID NO.</th>
                    <th>Schedule Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Created At</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log) <!-- Change $schedules to $logs -->
  
        <tr class="table-row">
            <td>{{ $log->id }}</td>
            <td class="room-name">
                {{ $log->schedule->classroom ? $log->schedule->classroom->classroom_name : 'N/A' }} <!-- Adjusted to access the classroom through the schedule -->
            </td>
            <td>{{ $log->user ? $log->user->name : 'N/A' }}</td>
            <td>{{ $log->schedule->subject ? $log->schedule->subject->subject_name : 'N/A' }} <!-- Adjusted to access the subject through the schedule -->
            </td>
            <td>{{ $log->rfid_no ?? 'N/A' }}</td> <!-- Fixed RFID -->

            <td class="entry-date" data-date="{{ \Carbon\Carbon::parse($log->schedule->schedule_day)->format('Y-m-d') }}">
                {{ \Carbon\Carbon::parse($log->schedule->schedule_day)->translatedFormat('l') }} <!-- Adjusted to access the schedule day through the schedule -->
            </td>
            <td>{{ \Carbon\Carbon::parse($log->start_time)->format('g:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($log->end_time)->format('g:i A') }}</td>
            <td class="entry-date" data-date="{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d') }}">
    {{ \Carbon\Carbon::parse($log->created_at)->format('F j, Y - g:i A') }}
</td>

            <td class="action-cell">
                <a href="{{ route('scheduleLogs.print', $log->id) }}" class="btn gradient-button print-button">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
            </td>
        </tr>

@endforeach
            </tbody>
        </table>
    </div>
</div>

@include('admin.footer')

<script>
    document.getElementById('searchInputStart').addEventListener('change', filterTable);
    document.getElementById('searchInputEnd').addEventListener('change', filterTable);
    document.getElementById('searchRoom').addEventListener('input', filterTable);

    function filterTable() {
    let startDate = document.getElementById('searchInputStart').value;
    let endDate = document.getElementById('searchInputEnd').value;
    let searchRoom = document.getElementById('searchRoom').value.toLowerCase();
    let table = document.getElementById('uniqueTable');
    let rows = table.getElementsByTagName('tr');

    // Convert start and end dates to Date objects
    let start = startDate ? new Date(startDate) : null;
    let end = endDate ? new Date(endDate) : null;

    for (let i = 1; i < rows.length; i++) {
        let dateCell = rows[i].getElementsByClassName('entry-date')[0];
        let roomCell = rows[i].getElementsByClassName('room-name')[0];

        if (dateCell && roomCell) {
            // Get the row date from the data attribute
            let rowDate = new Date(dateCell.getAttribute("data-date"));
            let roomText = roomCell.textContent.trim().toLowerCase();

            // Check if the row date is within the specified range
            let isInRange = true;
            if (start) {
                isInRange = rowDate >= start; // Check if row date is greater than or equal to start date
            }
            if (end) {
                isInRange = isInRange && rowDate <= end; // Check if row date is less than or equal to end date
            }

            // Check if the room name matches the search input
            let roomMatch = searchRoom === "" || roomText.includes(searchRoom);

            // Set the display property based on the filters
            rows[i].style.display = isInRange && roomMatch ? '' : 'none';
        }
    }
}

function printAll() {
    let startDate = document.getElementById('searchInputStart').value;
    let endDate = document.getElementById('searchInputEnd').value;
    let roomName = document.getElementById('searchRoom').value.trim();

    let url = "{{ route('scheduleLogs.printAll') }}";
    let params = [];

    if (startDate) params.push("start_date=" + encodeURIComponent(startDate));
    if (endDate) params.push("end_date=" + encodeURIComponent(endDate));
    if (roomName) params.push("room_name=" + encodeURIComponent(roomName));

    if (params.length > 0) {
        url += "?" + params.join("&");
    }

    window.location.href = url;
}


    function printSchedule(scheduleId) {
        let startDate = document.getElementById('searchInputStart').value;
        let endDate = document.getElementById('searchInputEnd').value;

        console.log("Start Date Sent:", startDate);
        console.log("End Date Sent:", endDate);

        let url = "{{ url('/admin/schedule-logs/print') }}/" + scheduleId +

            "?start_date=" + encodeURIComponent(startDate) +
            "&end_date=" + encodeURIComponent(endDate);

        window.location.href = url;
    }
</script>
