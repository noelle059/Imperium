 <!-- Header-->
@include('admin.header')

 <!-- Account-->
 <div class="page-content">

      <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Classroom Monitoring</h2>
            <input type="text" placeholder=" Search..." style="width: 20%; border: 1px solid #ccc; background-color: #f0f0f0; padding: 0; color: #123524; height: 30px;">
        </div>
      </div>


<div style="overflow-x: auto; padding-left: 20px; padding-right: 20px;"> <!-- Optional padding for the container -->
    <table id="uniqueTable" style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden; padding: 10px;"> <!-- Remove padding here -->
        <thead style="background-color: #47773f; color: white;">
            <tr>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Room No.</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Professor's Name</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Status</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Account No.</th>
                <th style="padding: 15px; text-align: left; border: 1px solid #ccc;">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: rgba(233, 233, 233, 0.795); color: #123524;">
                <td style="padding: 15px; border: 1px solid #ccc;">CL1</td>
                <td style="padding: 15px; border: 1px solid #ccc;">Prof. James Mitchell</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-warning">Unavailable</button>
                    <td style="padding: 15px; border: 1px solid #ccc;">12345678</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-primary">Remote</button></td>
            </tr>
            <tr style="background-color: rgba(233, 233, 233, 0.795); color: #123524;">
                <td style="padding: 15px; border: 1px solid #ccc;">CL2</td>
                <td style="padding: 15px; border: 1px solid #ccc;">-</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-success">Available</button></td>
                <td style="padding: 15px; border: 1px solid #ccc;">-</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-primary">Remote</button></td>
                </td>
            </tr>
            <tr style="background-color: rgba(233, 233, 233, 0.795); color: #123524;">
                <td style="padding: 15px; border: 1px solid #ccc;">CL3</td>
                <td style="padding: 15px; border: 1px solid #ccc;">Dr. Emily Roberts</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-warning">Unavailable</button>
                <td style="padding: 15px; border: 1px solid #ccc;">12345678</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ccc;"><button type="button" class="btn btn-primary">Remote</button></td>
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
