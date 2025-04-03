@include('admin.header')
{{-- CSS ADD --}}



<!-- Account-->
<div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Schedule Monitoring</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>


    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px;">
        <button class="btn gradient-button calendar" style="display: flex; align-items: center;" type="button"
                data-bs-toggle="modal" data-bs-target="#view_calendar_modal">
            <i class="fa fa-calendar" style="margin-right: 5px;"></i>
        </button>


        <button class="btn gradient-button add" style="display: flex; align-items: center;" type="button"
                data-bs-toggle="modal" data-bs-target="#add_schedule_modal">
            <i class="fa fa-plus" style="margin-right: 5px;"></i>
        </button>
    </div>


    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Classroom</th>
                    <th>Professor Assigned</th>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Start-Time</th>
                    <th>End-Time</th>
                    <th>Schedule added on</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $index => $schedule)
                    <tr class="table-row">
                        <td>{{ $index + 1 }}</td> <!-- Auto-increment number -->
                        <td>{{ $schedule->classroom->classroom_name ?? 'N/A' }}</td> <!-- Classroom name -->
                        <td>{{ $schedule->user->name ?? 'N/A' }}</td> <!-- Professor (User) name -->
                        <td>{{ $schedule->subject->subject_name ?? 'N/A' }}</td> <!-- Subject name -->
                        <td>{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('l') }}</td>
                        <!-- Day of the week -->
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td> <!-- Start time -->
                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td> <!-- End time -->
                        <td>{{ \Carbon\Carbon::parse($schedule->created_at)->format('M d, Y') }}</td>
                        <!-- Entry Date -->
                        <td class="action-cell">
                            <!-- Updating Schedule -->
                            <button class="btn gradient-button update" type="button" data-id="{{ $schedule->id }}"
                                data-classroom_id="{{ $schedule->classroom_id }}"
                                data-user_id="{{ $schedule->user_id }}" data-subject_id="{{ $schedule->subject_id }}"
                                data-subject_name="{{ $schedule->subject->subject_name }}"
                                data-subject-units="{{ $schedule->subject->units }}"
                                data-schedule_day="{{ $schedule->schedule_day }}"
                                data-start_time="{{ $schedule->start_time }}"
                                data-bs-toggle="modal"
                                data-bs-target="#update_schedule_modal">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </button>

                            <!-- Removing Schedule -->
                            <button class="btn gradient-button archive" type="button" data-id="{{ $schedule->id }}"
                                data-schedule_day="{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('Y-m-d') }}"
                                data-start_time="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                                data-end_time="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}"
                                id="RemoveScheduleButton">
                                <i class="fa-solid fa-box-archive"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="pagination" style="margin-top: 20px">
            {{ $schedules->links() }}
        </div>
    </div>

    {{-- INCLUDE ADMIN MODAL AND ALERT --}}
    @include('admin.modal.schedulesModals')
    @include('admin.modal.calendarModal')
    @include('admin.sweetAlerts.scheduleAlert')


    {{-- INCLUDE FOOTER --}}
    @include('admin.footer')


    <!-- Add your search script below -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let table = document.getElementById('uniqueTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let matchFound = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        let cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(filter) > -1) {
                            matchFound = true;
                        }
                    }
                }

                if (matchFound) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    </script>



    {{-- //BUTTON HOVER UPDATE --}}
    <style>
        /* Tooltip container */
        .update:hover::after {
            content: "Click to update";
            /* Tooltip text */
            position: absolute;
            top: -30px;
            /* Position above the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* Ensure the button is positioned correctly */
        .btn {
            position: relative;
        }
    </style>


    {{-- BUTTON HOVER ARCHIVE --}}
    <style>
        /* Tooltip container */
        .archive:hover::after {
            content: "Click to archive";
            /* Tooltip text */
            position: absolute;
            top: -30px;
            /* Position above the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* Ensure the button is positioned correctly */
        .btn {
            position: relative;
        }
    </style>


    {{-- // BUTTON HOVER ADD --}}
    <style>
        /* Tooltip container */
        .add:hover::after {
            content: "Click to add";
            /* Tooltip text */
            position: absolute;
            top: -30px;
            /* Position above the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .calendar:hover::after { /* For calendar to nakilagay lang */
            content: "Click to view calendar";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333333;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        #calendar {
            width: 100%;
            max-width: 100%;
            height: auto;
            min-height: 450px;
            margin: 0 auto;
            padding: 10px;
            overflow: hidden;
        }

        .modal-dialog {
            max-width: 90%;
            width: auto !important;
        }

        .modal-content {
            display: flex;
            flex-direction: column;
            height: auto;
        }


        #fc-dom-1{
            color: white;
        }


        /* Ensure the button is positioned correctly */
        .btn {
            position: relative;
        }
    </style>
