 @include('admin.header')

 <!-- Account-->
 <div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Professor Account Registration</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..." style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>


    <div class="table-container">
    <table id="uniqueTable" class="styled-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Account No.</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professors as $index => $professor)
                <tr class="table-row">
                    <td>{{ $loop->iteration }}</td> <!-- Auto-increment number -->
                    <td>{{ $professor->name }}</td>
                    <td>{{ $professor->email }}</td>
                    <td>{{ $professor->rfid_uid ?? 'N/A' }}</td>
                    <td>{{ $professor->is_activated ? 'Registered' : 'Pending Activation' }}</td>
                    <td class="action-cell">
                    <button class="btn gradient-button">
                        {{ $professor->is_activated ? 'Deactivate' : 'Activate' }}
                    </button>
                    </td>
                </tr>
            @endforeach
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
        let rows = document.querySelectorAll("#uniqueTable tbody tr");

        rows.forEach(row => {
            let name = row.cells[1].textContent.toLowerCase();
            let email = row.cells[2].textContent.toLowerCase();
            let accountNo = row.cells[3].textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter) || accountNo.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>


@include('admin.footer')
