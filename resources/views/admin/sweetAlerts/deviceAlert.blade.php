<!-- ADD DEVICE CONFIRMATION -->
<script>
    // Id of Button Submit
    document.getElementById('AddDeviceButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form input values
        const ClassNo = document.querySelector('[name="classroom_id"]').value;
        const DeviceName = document.querySelector('[name="device_name"]').value;

        // Validate if all required fields are filled
        if (!ClassNo || !DeviceName) {
            // If any field is empty, show a SweetAlert error
            Swal.fire({
                title: 'Error!',
                text: `Please fill all required fields.`,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // If all fields are filled, show the confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to add this device?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Add Device',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('AddDeviceForm').submit();
                }
            });
        }
    });
</script>
