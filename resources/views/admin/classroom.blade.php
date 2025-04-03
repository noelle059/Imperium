<!-- Header-->
@include('admin.header')


<div class="page-content">

    {{-- CLASSROOM --}}
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Classroom Monitoring</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder=" Search Classroom"
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px;">
        <button class="btn gradient-button add" style="display: flex; align-items: center; " type="button"
            data-bs-toggle="modal" data-bs-target="#add_classroom_modal">
            <i class="fa fa-plus" style="margin-right: 5px;"></i>
        </button>
    </div>

    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>Room No.</th>
                    <th>Clssroom Name</th>
                    <th>Device Count</th>
                    <th>Floor Level</th>
                    <th>Entry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classrooms as $index => $classroom)
                    <tr class="table-row">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $classroom->classroom_name }}</td>

                        <td>{{ $classroom->devices_count }}</td> <!-- This will display the device count -->

                        <td>{{ $classroom->floor ? $classroom->floor->floor_name : 'N/A' }}</td>
                        <!-- Display floor_name -->


                        <td>{{ \Carbon\Carbon::parse($classroom->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}
                        </td>

                        <td class="action-cell">
                            <!-- Updating Device from ID -->
                            <button class="btn gradient-button update" type="button" data-id="{{ $classroom->id }}"
                                data-classroom_name="{{ $classroom->classroom_name }}"
                                data-floor_id="{{ $classroom->floor_id }}" data-bs-toggle="modal"
                                data-bs-target="#update_classroom_modal">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>

                            </button>

                            <!-- Removing the subject from the list -->
                            <button class="btn gradient-button archive" type="button" data-id="{{ $classroom->id }}"
                                id="RemoveClassroomtButton">
                                <i class="fa-solid fa-box-archive"></i>

                            </button>
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

        <!-- Pagination controls -->
        <div class="pagination-container" style="margin-top: 10px;">
            {{ $classrooms->links() }}
        </div>

    </div>



    <!-- Footer-->
    @include('admin.footer')



    {{-- INCLUDE CLASSROOM MODALS --}}
    @include('admin.modal.classroomModals')
    <!-- @include('admin.sweetAlerts.classroomAlert') -->




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
        function fetchData(page = 1, searchValue = '') {
            $.ajax({
                url: "{{ route('show_classroom') }}",
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

        // Event Delegation for Search Input
        $(document).on('keyup', '#searchInput', function () {
            let searchValue = $(this).val();
            fetchData(1, searchValue);
        });

        // Event Delegation for Pagination
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let searchValue = $('#searchInput').val();
            fetchData(page, searchValue);
        });

        // Event Delegation for Update Button
        $(document).on('click', '.update', function () {
            let id = $(this).data('id');
            let classroom_name = $(this).data('classroom_name');
            let floor_id = $(this).data('floor_id');

            $('#classroom_name').val(classroom_name);
            $('#floor_id').val(floor_id);

            let form = $('#UpdateClassroomForm');
            form.attr('action', form.attr('action').replace(':id', id));
        });

        // Event Delegation for Update Button in Modal
        $(document).on('click', '#UpdateClassroomButton', function (e) {
            e.preventDefault();

            let classroom_name = $('#classroom_name').val();
            let ClassroomID = $('#UpdateClassroomForm').attr('action').split('/').pop();

            if (!classroom_name) {
                Swal.fire({
                    title: 'Error',
                    text: 'Please enter a classroom name.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to update the classroom: ${classroom_name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update Classroom',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let formAction = `/admin/update-classroom/${ClassroomID}`;
                    $('#UpdateClassroomForm').attr('action', formAction).submit();
                }
            });
        });

        // Event Delegation for Delete Button
        $(document).on('click', '.archive', function () {
            let id = $(this).data('id');  // Get the classroom id
            let row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will archive the classroom.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Archive',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/classroom/remove/${id}`,
                        type: 'PATCH',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Archived!', response.message, 'success');
                                row.remove();
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', 'Something went wrong while archiving the classroom.', 'error');
                        }
                    });
                }
            });
        });

        // Event Delegation for Add Classroom Button
        $(document).on('click', '#AddClassroomButton', function (e) {
            e.preventDefault();

            let form = $('#AddClassroomForm');
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    Swal.fire('Success!', 'Classroom added successfully.', 'success');
                    $('#add_classroom_modal').modal('hide');
                    fetchData();
                },
                error: function (xhr) {
                    Swal.fire('Error!', 'Failed to add classroom.', 'error');
                }
            });
        });
    });

    </script>

