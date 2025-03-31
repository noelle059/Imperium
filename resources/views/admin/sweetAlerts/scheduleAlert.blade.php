{{-- ADD SCHEDULE ALERT --}}
<script>
    document.getElementById('AddScheduleButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form input values
        const form = document.getElementById('AddScheduleForm');
        const formData = new FormData(form); // Get all form data
        const submitButton = document.getElementById('AddScheduleButton');

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
                fetch("{{ route('add_schedule') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: formData
                })
                .then(response => {
                    return response.json().catch(() => {
                        throw new Error("Invalid JSON response");
                    });
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Schedule Added',
                            text: data.message,
                        }).then(() => {
                            location.reload(); // Refresh the page after success
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Schedule',
                            html: data.errors.join('<br>'), // Display errors in SweetAlert
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                    });
                });

            }
        });
    });
</script>






{{-- REMOVE CLASSROOM ALERT --}}
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RemoveScheduleButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const ScheduleID = this.getAttribute('data-id');
            const scheduleDay = this.getAttribute('data-schedule_day');
            const startTime = this.getAttribute('data-start_time');
            const endTime = this.getAttribute('data-end_time');

            const scheduleDate = new Date(scheduleDay + ' ' + startTime);
            const scheduleEndDate = new Date(scheduleDay + ' ' + endTime);

            const currentDate = new Date();

            // Check if the schedule is ongoing (current time should be between start_time and end_time)
            if (currentDate >= scheduleDate && currentDate <= scheduleEndDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ongoing Schedule',
                    text: 'You cannot remove a currently ongoing schedule.',
                });
                return;
            }

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
                    fetch(`schedule/remove/${ScheduleID}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                archive_status: 0
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
                                    document.querySelector(`button[data-id="${ScheduleID}"]`)
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
