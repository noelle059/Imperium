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
    function fetchData(page = 1, searchValue = '') {
        $.ajax({
            url: "{{ route('subjects.index') }}",
            method: 'GET',
            data: { search: searchValue, page: page },
            success: function (response) {
                $('.table-container').html($(response).find('.table-container').html());
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    $(document).on('click', '#RemoveSubjectButton', function (event) {
        event.preventDefault();
        const subjectId = $(this).data('id');

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
                $.ajax({
                    url: `subjects/remove/${subjectId}`,
                    type: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: { archive_status: 0 },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Subject Removed',
                                text: data.message,
                            }).then(() => {
                                fetchData(); // ✅ Refresh the table
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Something went wrong. Please try again.',
                            });
                        }
                    },
                    error: function (xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to remove subject. Please try again later.',
                        });
                    }
                });
            }
        });
    });
</script>


