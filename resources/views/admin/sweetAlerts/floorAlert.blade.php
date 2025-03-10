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








<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RemoveFloortButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const floorID = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this floor level?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove Floor',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`floor/remove/${floorID}`, {
                            method: 'PATCH', // Use PATCH to update
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for protection
                            },
                            body: JSON.stringify({
                                archive_status: 0 // Set archive_status to 0
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // If the update is successful, show success message and remove the row from the table
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Floor Level Removed',
                                    text: 'The floor level has been removed successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${floorID}"]`)
                                        .closest('tr').remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.',
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to remove floor level. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>
