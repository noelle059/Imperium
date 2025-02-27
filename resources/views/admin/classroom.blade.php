 <!-- Header-->
@include('admin.header')

 <!-- Account-->
 <div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Classroom Monitoring</h2>
            
            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" placeholder=" Search..." style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
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
                <tr class="table-row">
                    <td>CL1</td>
                    <td>Prof. James Mitchell</td>
                    <td class="status-cell">In use</td>
                    <td>12345678</td>
                    <td>10:00 AM</td>
                    <td class="action-cell"><button type="button" class="btn gradient-button">Remote</button></td>
                </tr>
                <tr class="table-row">
                    <td>CL2</td>
                    <td>Not Applicable</td>
                    <td class="status-cell">Vacant</td>
                    <td>Not Applicable</td>
                    <td>Not Applicable</td>
                    <td class="action-cell"><button type="button" class="btn gradient-button">Remote</button></td>
                </tr>
                <tr class="table-row">
                    <td>CL3</td>
                    <td>Dr. Emily Roberts</td>
                    <td class="status-cell">In use</td>
                    <td>12345678</td>
                    <td>3:00 PM</td>
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



 <!-- Footer-->
    @include('admin.footer')
