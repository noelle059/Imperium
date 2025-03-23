@include('admin.header')

<!-- Account-->
<div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Device Monitoring</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>


    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px;">
        <button class="btn gradient-button add" style="display: flex; align-items: center; " type="button"
            data-bs-toggle="modal" data-bs-target="#add_device_modal">
            <i class="fa fa-plus" style="margin-right: 5px;"></i>
        </button>
    </div>


    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Device Name</th>
                    <th>Classroom Name</th>
                    {{-- <th>Status</th> --}}
                    <th>Entry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($show_devices as $index => $device)
                    <tr class="table-row">
                        <td>{{ $loop->iteration }}</td> <!-- Auto-increment number -->
                        <td>{{ $device->device_name }}</td>

                        <td>
                            <!-- Find the classroom name by classroom_id -->
                            @php
                                $classroom = $classrooms->firstWhere('id', $device->classroom_id);
                            @endphp

                            <!-- Display the classroom name if found -->
                            {{ $classroom ? $classroom->classroom_name : 'N/A' }}
                        </td>


                        {{-- <td>
                            @if ($device->state == 0)
                                OFF
                            @elseif ($device->state == 1)
                                ON
                            @endif
                        </td> --}}

                        <td>{{ \Carbon\Carbon::parse($device->created_at)->timezone(value: 'Asia/Manila')->format('F j, Y \a\t h:i A') }}
                        </td>

                        <td class="action-cell">


                            <!-- Updating Device from ID -->
                            <button class="btn gradient-button update" type="button" data-id="{{ $device->id }}"
                                data-device_name="{{ $device->device_name }}"
                                data-classroom_id="{{ $device->classroom_id }}" data-state="{{ $device->state }}"
                                data-bs-toggle="modal" data-bs-target="#update_device__modal">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>

                            </button>

                            <!-- Removing the subject from the list -->
                            <button class="btn gradient-button archive" type="button" data-id="{{ $device->id }}"
                                id="RemoveDevicetButton">
                                <i class="fa-solid fa-box-archive"></i>

                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



















    {{-- INCLUDE ADMIN MODAL AND ALERT --}}
    @include('admin.modal.deviceModals')
    @include('admin.sweetAlerts.deviceAlert')


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
