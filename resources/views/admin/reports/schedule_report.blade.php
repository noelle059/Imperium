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

    <div style="display: flex; justify-content: flex-end; margin-top: 10px; padding-right: 20px;">
        <a href="#" onclick="printAll()" class="btn gradient-button">
            <i class="fa-solid fa-file-pdf"></i> PRINT ALL
        </a>
    </div>

    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>Schedule ID</th>
                    <th>Classroom</th>
                    <th>Professor</th>
                    <th>Subject</th>
                    <th>Schedule Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    @if ($schedule->archive_status == 1)
                        <tr class="table-row">
                            <td>{{ $schedule->id }}</td>
                            <td class="room-name">
                                {{ $schedule->classroom ? $schedule->classroom->classroom_name : 'N/A' }}</td>
                            <td>{{ $schedule->user ? $schedule->user->name : 'N/A' }}</td>
                            <td>{{ $schedule->subject ? $schedule->subject->subject_name : 'N/A' }}</td>
                            <td class="entry-date"
                                data-date="{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('Y-m-d') }}">
                                {{ \Carbon\Carbon::parse($schedule->schedule_day)->translatedFormat('F j, Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
                            <td class="action-cell">
                                <a href="{{ route('schedule.print', $schedule->id) }}" class="btn gradient-button">
                                    <i class="fa-solid fa-file-pdf"></i> PRINT
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

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

            let start = startDate ? new Date(startDate) : null;
            let end = endDate ? new Date(endDate) : null;

            for (let i = 1; i < rows.length; i++) {
                let dateCell = rows[i].getElementsByClassName('entry-date')[0];
                let roomCell = rows[i].getElementsByClassName('room-name')[0];

                if (dateCell && roomCell) {
                    let rowDate = new Date(dateCell.getAttribute("data-date")); // ✅ Read from data-date attribute
                    let roomText = roomCell.textContent.trim().toLowerCase();

                    let isInRange = (!start || rowDate.getTime() >= start.getTime()) &&
                        (!end || rowDate.getTime() <= end.getTime()) ||
                        (start && !end);

                    let roomMatch = searchRoom === "" || roomText.includes(searchRoom);

                    rows[i].style.display = isInRange && roomMatch ? '' : 'none';
                }
            }
        }

        function printAll() {
            let startDate = document.getElementById('searchInputStart').value;
            let endDate = document.getElementById('searchInputEnd').value;

            let url = "{{ route('schedule.printAll') }}";

            // Append query parameters only if dates are selected
            let params = [];
            if (startDate) params.push("start_date=" + encodeURIComponent(startDate));
            if (endDate) params.push("end_date=" + encodeURIComponent(endDate));

            if (params.length > 0) {
                url += "?" + params.join("&");
            }

            window.location.href = url;
        }


        function printSchedule(scheduleId) {
            let startDate = document.getElementById('searchInputStart').value;
            let endDate = document.getElementById('searchInputEnd').value;

            console.log("Start Date Sent:", startDate); // Debugging
            console.log("End Date Sent:", endDate); // Debugging

            let url = "{{ url('/admin/schedule/print') }}/" + scheduleId +
                "?start_date=" + encodeURIComponent(startDate) +
                "&end_date=" + encodeURIComponent(endDate);

            window.location.href = url;
        }
    </script>
