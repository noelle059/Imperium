<!-- ADD FLOOR CONFIRMATION -->
<script>
    // Id of Button Submit
    document.getElementById('AddFloorButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form input values
        const FloorLevelName = document.querySelector('[name="floor_name"]').value;

        // Validate if all required fields are filled
        if (!FloorLevelName) {
            // If any field is empty, show a SweetAlert error
            Swal.fire({
                title: 'Error!',
                text: `Please enter floor level name.`,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // If all fields are filled, show the confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to add this ${FloorLevelName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Add Floor level',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('AddFloorForm').submit();
                }
            });
        }
    });
</script>
