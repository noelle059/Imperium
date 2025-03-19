{{-- ADD SCHEDULE ALERT --}}
<script>
    // Id of Button Submit
    document.getElementById('AddScheduleButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form input values
        const ClassroomName = document.querySelector('[name="classroom_id"]').value;
        const ProfessorName = document.querySelector('[name="user_id"]')
            .value; // Get the value of the professor select
        const SubjectName = document.querySelector('[name="subject_id"]')
            .value; // Get the value of the subject select
        const Date = document.querySelector('[name="date"]').value;
        const StartTime = document.querySelector('[name="start_time"]').value;
        const EndTime = document.querySelector('[name="end_time"]').value;

        // Validate if all required fields are filled
        if (!ClassroomName || !ProfessorName || !SubjectName || !Date || !StartTime || !EndTime) {
            // If any field is empty, show a SweetAlert error
            let errorMessage = "Please enter the following fields: ";

            // Adding missing fields to the error message
            if (!ClassroomName) errorMessage += "Classroom, ";
            if (!ProfessorName) errorMessage += "Professor, ";
            if (!SubjectName) errorMessage += "Subject, ";
            if (!Date) errorMessage += "Date, ";
            if (!StartTime) errorMessage += "Start Time, ";
            if (!EndTime) errorMessage += "End Time, ";

            // Remove last comma and space if there are any missing fields
            errorMessage = errorMessage.replace(/, $/, "");

            // Show the SweetAlert with the missing fields
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // If all fields are filled, show the confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to add the schedule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Add Schedule',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('AddScheduleForm').submit();
                }
            });
        }
    });
</script>





{{-- REMOVE CLASSROOM ALERT --}}
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RemoveScheduleButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const ScheduleID = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to remove this schedule?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove Schedule',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`schedule/remove/${ScheduleID}`, {
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
                                    title: 'Schedule Removed',
                                    text: 'The Schedule has been removed successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${ScheduleID}"]`)
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
                                text: 'Unable to remove schedule. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>
