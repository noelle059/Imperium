{{-- Include Header --}}
@include('user.header')

{{-- Include Header --}}
@include('user.navigationbar')

@include('user.modal.entry')


<div class="page-header">
    <div class="container-fluid"
        style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <!-- Title (SCHEDULE MONITORING) -->
        <h2 class="h5 no-margin-bottom" style="flex: 1; text-align: left; margin-bottom: 10px;">SCHEDULE MONITORING</h2>

        <!-- Date and Time -->
        <h6 class="h5 no-margin-bottom" style="flex: 1; text-align: center; margin-bottom: 10px;">
            <span id="date-time">{{ $currentDateTime }}</span>
        </h6>

        <!-- Search Box -->
        <div style="display: flex; align-items: center; flex: 1; justify-content: flex-end; margin-bottom: 10px;">
            <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
            <input type="text" id="searchInput" placeholder="Search Classroom"
                style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0 10px;">
        </div>
    </div>
</div>




<div class="table-container">
    <table id="uniqueTable" class="styled-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Classroom</th>
                <th>Professor</th>
                <th>Subject</th>
                <th>Day</th>
                <th>Start-Time</th>
                <th>End-Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($floors as $floor)
                <tr class="floor-header">
                    <td colspan="8" class="floor-name">
                        <strong>{{ $floor->floor_name }}</strong>
                    </td>
                </tr>

                @foreach ($floor->classrooms as $classroom)
                    @php
                        $activeLog = $classroom->schedules->flatMap->scheduleLogs->where('end_time', null)->first();
                        $schedule = $activeLog ? $activeLog->schedule : null;
                    @endphp

                    <tr class="table-row">
                        <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td>{{ $classroom->classroom_name }}</td>
                        <td>{{ $schedule->professor->name ?? 'N/A' }}</td>
                        <td>{{ $schedule->subject->subject_name ?? 'N/A' }}</td>
                        <td>{{ $schedule ? \Carbon\Carbon::parse($schedule->schedule_day)->format('F j, Y') : 'N/A' }}
                        </td>
                        <td>{{ $schedule && $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') : 'N/A' }}
                        </td>
                        <td>{{ $schedule && $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') : 'N/A' }}
                        </td>
                        <td class="action-cell">
                            @if ($activeLog && $schedule->user_id === auth()->user()->id)
                                <button class="btn gradient-button controller" type="button"
                                    data-id="{{ $classroom->id }}"
                                    data-classroom-name="{{ $classroom->classroom_name }}" data-bs-toggle="modal"
                                    data-bs-target="#controlModal">
                                    <i class="fa-solid fa-gamepad"></i>
                                </button>

                                <button class="btn gradient-button exit" type="button" data-id="{{ $classroom->id }}"
                                    data-bs-toggle="modal" data-bs-target="#room_exit">
                                    <i class="fa-solid fa-door-closed"></i>
                                </button>
                            @elseif (!$activeLog)
                                <button class="btn gradient-button entry" type="button" data-id="{{ $classroom->id }}"
                                    data-bs-toggle="modal" data-bs-target="#entryModal">
                                    <i class="fa-solid fa-door-open"></i>
                                </button>
                            @else
                                <span class="text-muted">No Access</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>




<!-- Controller Modal -->
<div class="modal fade" id="controlModal" tabindex="-1" aria-labelledby="controlModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="controlModalTitle">Name of the Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container" id="device-controls-container">
                    <!-- Devices will be injected here dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<!-- Exit Modal -->
<div class="modal fade" id="room_exit" tabindex="-1" aria-labelledby="roomExitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roomExitLabel">Exit Classroom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <label class="fw-bold text-danger">Scan RFID to Exit:</label>

                <label id="exitRfidLabel" class="mt-3 fw-bold text-danger" style="display: none;">
                    Scanning RFID...
                </label>

                <button id="confirmExit" class="btn btn-outline-danger mt-3 w-100" style="display: none;">
                    CONFIRM EXIT
                </button>
            </div>
        </div>
    </div>
</div>



{{-- Include Footer --}}
@include('user.footer')




<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="module">
    // Import Firebase functions
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";
    import {
        getDatabase,
        ref,
        onValue,
        update,
        get
    } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-database.js";

    const firebaseConfig = {
        apiKey: "AIzaSyB8wMtr-QwTxDQ0m86rUTY_BYeP-9z8tMg",
        authDomain: "imperium---classroomautomation.firebaseapp.com",
        databaseURL: "https://imperium---classroomautomation-default-rtdb.firebaseio.com",
        projectId: "imperium---classroomautomation",
        storageBucket: "imperium---classroomautomation.firebasestorage.app",
        messagingSenderId: "1037315551683",
        appId: "1:1037315551683:web:6abb03bc60964037f3cd76",
        measurementId: "G-WF30WFY4HZ"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);





    // Fetch and display devices when the modal is shown
    $('#controlModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var classroomId = button.data('id'); // Extract classroom ID
        var classroomName = button.data('classroom-name'); // Extract classroom name

        var modal = $(this);
        modal.find('.modal-title').text('Controller for ' + classroomName); // Set the modal title dynamically

        // Fetch devices for the selected classroom
        $.ajax({
            url: '/professor/get-devices/' + classroomId, // Endpoint to get devices
            method: 'GET',
            success: function(data) {
                // Clear the container before injecting devices
                $('#device-controls-container').empty();

                // If no devices are found
                if (data.devices.length === 0) {
                    $('#device-controls-container').append(
                        '<p>No devices available for this classroom.</p>');
                }

                // Loop through the devices and create the switch for each
                data.devices.forEach(function(device) {
                    var checked = device.state ? 'checked' :
                        ''; // Ensure this is properly converted to a boolean

                    var deviceControl = `
                <div class="card">
                    <label for="switch${device.id}">
                        <i class="bi bi-lightbulb" id="icon${device.id}"></i> ${device.device_name}
                    </label>
                    <label class="switch">
                        <input type="checkbox" id="switch${device.id}"
                               data-device-id="${device.id}"
                               data-classroom-id="${classroomId}"
                               data-device-name="${device.device_name}"
                               ${checked}
                               onclick="toggleSwitch(${device.id}, ${classroomId}, '${device.device_name}')">
                        <span class="slider"></span>
                    </label>
                </div>
            `;
                    $('#device-controls-container').append(deviceControl);
                });

                // Now you have the device IDs from the data.device_ids array
                // You can do whatever is necessary with the device IDs here
                console.log('Device IDs:', data
                    .device_ids); // Example of how to access the device IDs

                // Sync the UI with Firebase state after loading
                syncDeviceStateWithFirebase(classroomId); // Make sure classroomId is passed here
            },
            error: function(error) {
                console.log('Error fetching devices:', error);
            }
        });
    });




    // Sync device states with Firebase
    function syncDeviceStateWithFirebase(classroomId) {
        const deviceRef = ref(db, `classrooms/${classroomId}/devices/`);
        onValue(deviceRef, (snapshot) => {
            const devices = snapshot.val();
            console.log(devices); // Check the data structure

            // Loop through devices and update UI
            if (devices) {
                Object.keys(devices).forEach(deviceId => {
                    const device = devices[deviceId];
                    // Update the UI with the device states
                    updateDeviceUI(deviceId, device);

                    // console.log(`Device Id Sync: ${deviceId}`);

                });
            }
        });

    }



    // Update the switch state on the UI
    function updateDeviceUI(deviceId, device) {
        const switchElement = document.getElementById(`switch${deviceId}`);
        if (switchElement) {
            // Update the switch based on the Firebase state (true or false)
            switchElement.checked = device.state === true;
        }
        // console.log(`Device Id: ${deviceId}`);
    }


    // Function to handle the switch toggle
    function toggleSwitch(deviceId, classroomId, deviceName) {
        console.log('Device ID:', deviceId); // Check the device ID passed
        console.log('Classroom ID:', classroomId); // Check the classroom ID passed
        console.log('Device Name:', deviceName); // Check the device name passed

        if (!deviceId) {
            console.error('Device ID is undefined');
            return; // If deviceId is undefined, stop the function
        }

        var switchElement = document.getElementById('switch' + deviceId);
        var isChecked = switchElement.checked; // Accessing the `checked` property of the checkbox directly

        console.log(`Switch for ${deviceName} toggled`);
        console.log(`Checkbox state: ${isChecked}`); // Log the state of the checkbox

        var newState = isChecked; // Directly use the boolean state (true or false)

        console.log(`newState before Firebase update: ${newState}`); // Log the newState before updating Firebase

        // Update device state in Firebase immediately
        const deviceStateRef = ref(db,
            `classrooms/${classroomId}/devices/${deviceId}`); // Correct Firebase reference

        // Ensure the reference is correct by checking the path in the console
        console.log('Firebase path:', `classrooms/${classroomId}/devices/${deviceId}`);

        // Update Firebase with the new state
        update(deviceStateRef, {
            state: newState
        }).then(() => {
            console.log('Device state updated in Firebase');
        }).catch(error => {
            console.log('Error updating Firebase:', error);
        });
    }

    // Expose toggleSwitch to the global scope
    window.toggleSwitch = toggleSwitch;
</script>





















<script>
    // JavaScript to update date and time every second
    function updateDateTime() {
        const dateTimeElement = document.getElementById('date-time');
        const currentDateTime = new Date().toLocaleString('en-PH', {
            timeZone: 'Asia/Manila',
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true
        });
        dateTimeElement.textContent = currentDateTime;
    }

    // Update every second
    setInterval(updateDateTime, 1000);
</script>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        let exitModal = document.getElementById("room_exit");
        let confirmExitBtn = document.getElementById("confirmExit");
        let exitRfidLabel = document.getElementById("exitRfidLabel");

        document.querySelectorAll(".exit").forEach(button => {
            button.addEventListener("click", function() {
                let classroomId = this.getAttribute("data-id");
                exitModal.setAttribute("data-classroom-id", classroomId);
                console.log("Exit modal opened for Classroom ID:", classroomId);
            });
        });

        exitModal.addEventListener("show.bs.modal", function() {
            exitRfidLabel.style.display = "block";
            exitRfidLabel.textContent = "Scanning RFID...";
            confirmExitBtn.style.display = "none";
            confirmExitBtn.disabled = true;
            setInterval(() => {
                fetchProfessorRFIDForExit();
            }, 3000);
        });

        function fetchProfessorRFIDForExit() {
            fetch("/get-professor-rfid")
                .then(response => response.json())
                .then(professorData => {
                    console.log("Professor RFID for exit:", professorData.rfid_uid);
                    checkExitRFIDMatch(professorData.rfid_uid);
                })
                .catch(error => console.error("Error fetching professor RFID:", error));
        }

        function checkExitRFIDMatch(professorRFID, classroomID) {
            const superAdminRFID = "23b28d14"; // Define the Super Admin RFID

            fetch("/get-rfid")
                .then(response => response.json())
                .then(data => {
                    console.log("Scanned RFID for exit:", data.rfid);

                    if (data.rfid) {
                        exitRfidLabel.textContent = `Scanned RFID: ${data.rfid}`;
                        exitRfidLabel.style.display = "block";

                        const scannedRFID = String(data.rfid).trim();

                        if (scannedRFID === String(professorRFID).trim() || scannedRFID === superAdminRFID) {
                            // Allow exit
                            confirmExitBtn.disabled = false;
                            confirmExitBtn.style.display = "block";
                        } else {
                            // Deny exit
                            Swal.fire({
                                icon: "error",
                                title: "Access Denied",
                                text: "RFID does not match the logged-in professor or Super Admin!",
                                timer: 2500,
                                showConfirmButton: false
                            });
                            confirmExitBtn.disabled = true;
                        }
                    }
                })
                .catch(error => console.error("Error fetching RFID from Firebase:", error));
        }
        setInterval(function() {
            fetch('{{ url('/check-archive-status') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('Archive status data:', data);
                if (data.archived) {
                    // Redirect to the homepage with the archived query parameter
                    window.location.href = '{{ route('home') }}?archived=true';
                }
            })
            .catch(error => {
                console.error('Error checking archive status:', error);
            });
        }, 5000);

        function updateAccessState(accessState) {
            return fetch('/update-access-state', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ access_state: accessState })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(`Access state updated to ${accessState}.`);
                } else {
                    console.error(`Failed to update access state: ${data.message}`);
                }
            })
            .catch(error => console.error('Error updating access state:', error));
        }



        confirmExitBtn.addEventListener("click", function() {
            let professorId = "{{ auth()->user()->id }}";
            let classroomId = exitModal.getAttribute("data-classroom-id");

            if (!classroomId) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No classroom selected!",
                });
                return;
            }

            fetch(`/active-log?professor_id=${professorId}&classroom_id=${classroomId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.active) {
                        Swal.fire({
                            icon: "error",
                            title: "No Active Session",
                            text: "You do not have an active session in this classroom!",
                        });
                        return;
                    }

                    fetch(`/schedule-log/${data.log_id}/exit`, {
                            method: "PUT",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                end_time: new Date().toISOString(),
                            }),
                        })
                        .then(response => response.json())
                        .then(responseData => {
                            if (responseData.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Exit Logged",
                                    text: "You have successfully exited the classroom.",
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    let modalInstance = bootstrap.Modal.getInstance(
                                        exitModal);
                                    if (modalInstance) {
                                        modalInstance.hide();
                                    }
                                    window.location.reload();
                                    updateAccessState(false);
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Exit Failed",
                                    text: "Something went wrong!",
                                });
                            }
                        })
                        .catch(error => console.error("Error logging exit:", error));
                })
                .catch(error => console.error("Error checking active log:", error));
        });
    });
</script>




</body>

</html>
