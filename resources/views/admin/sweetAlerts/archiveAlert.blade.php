<!-- RETRIEVE ACCOUNT CONFIRMATION -->
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RetrieveAccountButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const accountID = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to retrieve this account?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Retrieve Account',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`/admin/accounts/retrieve/${accountID}`, {
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
                                    title: 'Account Retrive',
                                    text: 'The account has been retrive successfully.',
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
                                text: 'Unable to retrieve. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>







<!-- RETRIEVE FLOOR CONFIRMATION -->
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RetrieveFloortButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const iD = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to retrieve this floor?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Retrieve Floor',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`/admin/floor/retrieve/${iD}`, {
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
                                    title: 'Floor Retrive',
                                    text: 'The floor has been retrive successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${iD}"]`)
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
                                text: 'Unable to  retrieve. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>




<!-- RETRIEVE CLASSROOM CONFIRMATION -->
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RetrieveClassroomtButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const iD = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to retrieve this classroom?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Retrieve Classroom',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`/admin/classroom/retrieve/${iD}`, {
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
                                    title: 'Classroom Retrive',
                                    text: 'The classroom has been retrive successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${iD}"]`)
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
                                text: 'Unable to  retrieve. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>




<!-- RETRIEVE DEVICE CONFIRMATION -->
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RetrieveDevicetButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const iD = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to retrieve this device?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Retrieve Device',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`/admin/device/retrieve/${iD}`, {
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
                                    title: 'Device Retrive',
                                    text: 'The Device has been retrive successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${iD}"]`)
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
                                text: 'Unable to  retrieve. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>





<!-- RETRIEVE SCHEDULE CONFIRMATION -->
<script>
    // Attach event listener to the "REMOVE" button
    document.querySelectorAll('#RetrieveScheduleButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            const iD = this.getAttribute('data-id'); // Get subject ID

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to retrieve this schedule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Retrieve Schedule',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to update the archive status to 0 (removed)
                    fetch(`/admin/schedule/retrieve/${iD}`, {
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
                                    title: 'Schedule Retrive',
                                    text: 'The Schedule has been retrive successfully.',
                                }).then(() => {
                                    // Optionally, remove the subject row from the table
                                    document.querySelector(
                                            `button[data-id="${iD}"]`)
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
                                text: 'Unable to  retrieve. Please try again later.',
                            });
                        });
                }
            });
        });
    });
</script>
