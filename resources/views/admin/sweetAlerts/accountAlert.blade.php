<!-- UPDATE ACCOUNT CONFIRMATION -->
<script>
    // Attach event listener to the Update button
    document.getElementById('UpdateAccountButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the form submission immediately

        // Get form input values
        const accountRfid = document.querySelector('[name="rfid_uid"]').value;

        // If all fields are filled, show the confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to update Account No. ${accountRfid} to this?`, // Corrected to use backticks
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Update Account',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('UpdateAccountForm').submit(); // Submit the form
            }
        });

    });
</script>






<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RemoveAccountButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const accountID = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this account?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove Account',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`accounts/remove/${accountID}`, {
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
                                    title: 'Account Removed',
                                    text: 'The account has been removed successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${accountID}"]`)
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
                                text: 'Unable to remove account. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>
