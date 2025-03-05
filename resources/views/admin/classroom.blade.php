 <!-- Header-->
@include('admin.header')

 <!-- Account-->
 <div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Classroom Monitoring</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder=" Search..." style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>


    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>Room No.</th>
                    <th>Professor's Name</th>
                    <th>Status</th>
                    <th>Account No.</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="table-row">
                        <td>CL{{ $room->room_name }}</td>
                        <td>{{ $room->professor_name ?? 'N/A' }}</td>
                        <td class="status-cell">{{ $room->status === 'Available' ? 'Vacant' : 'In Use' }}</td>
                        <td>{{ $room->account_no ?? 'N/A' }}</td>
                        <td>{{ $room->time_in ?? 'N/A' }}</td>
                        <td class="action-cell">
                            <button type="button" class="btn gradient-button">Remote</button>
                        </td>
                    </tr>
                @endforeach
                <tr class="table-row">
                    <td>CL2</td>
                    <td>Prof. James Mitchell</td>
                    <td class="status-cell">In use</td>
                    <td>12345678</td>
                    <td>10:00 AM</td>
                    <td class="action-cell"><button type="button" class="btn gradient-button">Remote</button></td>
                </tr>
            </tbody>

        </table>
    </div>


<script>
    // Add hover effect for rows using JavaScript
    const rows = document.querySelectorAll('#uniqueTable tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseover', () => {
            row.style.backgroundColor = 'rgba(200, 200, 200, 0.5)';
        });
        row.addEventListener('mouseout', () => {
            row.style.backgroundColor = 'rgba(233, 233, 233, 0.795)';
        });
    });
</script>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#uniqueTable tbody tr');

        rows.forEach(row => {
            let roomNo = row.cells[0].textContent.toLowerCase();
            let professor = row.cells[1].textContent.toLowerCase();
            let accountNo = row.cells[3].textContent.toLowerCase();

            if (roomNo.includes(filter) || professor.includes(filter) || accountNo.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>


 <!-- Footer-->
    @include('admin.footer')
