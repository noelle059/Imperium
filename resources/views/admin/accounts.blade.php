 @include('admin.header') 

 <!-- Account-->
 <div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Professor Account Registration</h2>
            
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
                <th>No.</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Account No.</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-row">
                <td>1</td>
                <td>John</td>
                <td>Doe</td>
                <td>john@example.com</td>
                <td>12345678</td>
                <td>Registered</td>
                <td class="action-cell"><button type="button" class="btn gradient-button">Register</button></td>
            </tr>
            <tr class="table-row">
                <td>2</td>
                <td>Mary</td>
                <td>Moe</td>
                <td>mary@example.com</td>
                <td>Pending Activation</td>
                <td>Pending</td>
                <td class="action-cell"><button type="button" class="btn gradient-button">Register</button></td>
            </tr>
            <tr class="table-row">
                <td>3</td>
                <td>July</td>
                <td>Dooley</td>
                <td>july@example.com</td>
                <td>12345678</td>
                <td>Registered</td>
                <td class="action-cell"><button type="button" class="btn gradient-button">Register</button></td>
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



@include('admin.footer')
