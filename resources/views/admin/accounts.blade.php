 @include('admin.header') 

 <!-- Account-->
 <div class="page-content">

      <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Account Registration</h2>
            <input type="text" placeholder=" Search..." style="width: 20%; border: 1px solid #ccc; background-color: #f0f0f0; padding: 0; color: #123524; height: 30px;">
        </div>
      </div>


    <!-- <h2 style="padding-left: 20px; color: #123524;">Registration</h2> -->
 <!--<p style="padding-left: 20px; color: #123524;">Please register the professors who do not have an account number in this section:</p>-->
<div style="overflow-x: auto; padding-left: 20px; padding-right: 20px;"> <!-- Optional padding for the container -->
    <table id="uniqueTable" style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden; padding: 10px;"> <!-- Remove padding here -->
        <thead style="background-color: #47773f; color: white;">
            <tr>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">No.</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Firstname</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Lastname</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Email</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Account No.</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: rgba(233, 233, 233, 0.795); color: #123524;">
                <td style="padding: 15px; border: 1px solid #ccc;">1</td>
                <td style="padding: 15px; border: 1px solid #ccc;">John</td>
                <td style="padding: 15px; border: 1px solid #ccc;">Doe</td>
                <td style="padding: 15px; border: 1px solid #ccc;">john@example.com</td>
                <td style="padding: 15px; border: 1px solid #ccc;">12345678</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-success">Registerd</button></td>
            </tr>
            <tr style="background-color: rgba(233, 233, 233, 0.795); color: #123524;">
                <td style="padding: 15px; border: 1px solid #ccc;">2</td>
                <td style="padding: 15px; border: 1px solid #ccc;">Mary</td>
                <td style="padding: 15px; border: 1px solid #ccc;">Moe</td>
                <td style="padding: 15px; border: 1px solid #ccc;">mary@example.com</td>
                <td style="padding: 15px; border: 1px solid #ccc;">-</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-warning">Pending</button>
                </td>
            </tr>
            <tr style="background-color: rgba(233, 233, 233, 0.795); color: #123524;">
                <td style="padding: 15px; border: 1px solid #ccc;">3</td>
                <td style="padding: 15px; border: 1px solid #ccc;">July</td>
                <td style="padding: 15px; border: 1px solid #ccc;">Dooley</td>
                <td style="padding: 15px; border: 1px solid #ccc;">july@example.com</td>
                <td style="padding: 15px; border: 1px solid #ccc;">12345678</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-success">Registerd</button></td>
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
