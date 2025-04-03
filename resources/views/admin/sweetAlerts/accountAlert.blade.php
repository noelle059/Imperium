<script>
    function fetchData(page = 1, searchValue = '') {
        $.ajax({
            url: "{{ route('accounts') }}",
            method: 'GET',
            data: { search: searchValue, page: page },
            success: function (response) {
                $('#tableSection').html($(response.html).find('#tableSection').html());
                attachEventListeners(); // Reattach event listeners
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    $(document).on('click', '#RemoveAccountButton', function (event) {
        event.preventDefault();

        const accountID = $(this).data('id');

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
                fetch(`accounts/remove/${accountID}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ archive_status: 0 })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Account Removed',
                            text: data.message,
                        }).then(() => {
                            fetchData(); // ✅ Auto-refresh the table
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Something went wrong. Please try again.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to remove account. Please try again later.',
                    });
                });
            }
        });
    });
</script>
