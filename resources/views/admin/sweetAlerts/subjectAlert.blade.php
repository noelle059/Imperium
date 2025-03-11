<!-- ADD SUBJECT CONFIRMATION -->
<script>
    document.getElementById('AddSubjectButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form input values
        const subjectCode = document.querySelector('[name="subject_code"]').value;
        const subjectName = document.querySelector('[name="subject_name"]').value;
        const subjectUnits = document.querySelector('[name="subject_units"]').value;

        // Validate if all required fields are filled
        if (!subjectCode || !subjectName || !subjectUnits) {
            // If any field is empty, show a SweetAlert error
            Swal.fire({
                title: 'Error!',
                text: 'Please fill all required fields.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // If all fields are filled, show the confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to add this subject?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Add Subject',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('AddSubjectForm').submit();
                }
            });
        }
    });
</script>



{{-- REMOVE SUBJECT ALERT --}}
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RemoveSubjectButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const subjectId = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this subject?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove Subject',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`subjects/remove/${subjectId}`, {
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
                                    title: 'Subject Removed',
                                    text: 'The subject has been removed successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${subjectId}"]`)
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
                                text: 'Unable to remove subject. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>
