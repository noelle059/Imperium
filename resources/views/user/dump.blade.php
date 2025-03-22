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
                            <label for="switch${device.device_name}">
                                <i class="bi bi-lightbulb" id="icon${device.device_name}"></i> ${device.device_name}
                            </label>
                            <label class="switch">
                                <input type="checkbox" id="switch${device.device_name}"
                                       data-device-id="${device.device_name}"
                                       data-classroom-id="${classroomId}"
                                       data-device-name="${device.device_name}"
                                       ${checked}
                                       onclick="toggleSwitch('${device.device_name}', '${classroomId}', '${device.device_name}')">
                                <span class="slider"></span>
                            </label>
                        </div>
                    `;
                    $('#device-controls-container').append(deviceControl);
                });

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

            // Convert devices object to an array
            const deviceArray = Object.keys(devices).map(key => devices[key]);

            // Now you can safely use forEach to update the UI
            deviceArray.forEach(device => {
                // Update the UI with the device states
                updateDeviceUI(device);
            });
        });
    }

    // Update the switch state on the UI
    function updateDeviceUI(device) {
        const switchElement = document.getElementById(`switch${device.device_name}`);
        if (switchElement) {
            // Update the switch based on the Firebase state (true or false)
            switchElement.checked = device.state === true;
        }
    }

    // Function to handle the switch toggle
    function toggleSwitch(deviceId, classroomId, deviceName) {
        // Get the new state of the switch (true/false)
        var isChecked = $('#switch' + deviceId).is(':checked'); // Returns a boolean
        var newState = isChecked; // Directly use the boolean state (true or false)

        // Update device state in Firebase
        const deviceStateRef = ref(db, `classrooms/${classroomId}/devices/${deviceName}`);
        update(deviceStateRef, {
            state: newState
        }).then(() => {
            console.log('Device state updated in Firebase');

            // Wait for the state update to be completed before syncing the UI
            setTimeout(() => {
                // Fetch the updated device state from Firebase
                const updatedDeviceRef = ref(db, `classrooms/${classroomId}/devices/${deviceName}`);
                get(updatedDeviceRef).then((snapshot) => {
                    const updatedDevice = snapshot.val();
                    if (updatedDevice) {
                        // After the state is updated in Firebase, update the UI
                        updateDeviceUI(updatedDevice);
                    }
                }).catch((error) => {
                    console.error('Error fetching updated device state:', error);
                });
            }, 5000); // You can adjust the delay if needed
        }).catch(error => {
            console.log('Error updating Firebase:', error);
        });

        // Send the new state to the server (backend) as well
        $.ajax({
            url: '/professor/update-device-state/' + classroomId + '/' + deviceName, // Endpoint
            method: 'POST',
            data: {
                state: newState, // Send the boolean state (true or false)
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Device state updated on server:', response);
            },
            error: function(error) {
                console.log('Error updating device state:', error);
            }
        });
    }

    // Expose toggleSwitch to the global scope
    window.toggleSwitch = toggleSwitch;
</script>
































<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Firebase SDK (Modular approach for v9 and above) -->
    <script type="module" src="/scripts/remote_script.js"></script>
    <script type="module" src="/scripts/dynamicRemoteScript.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        body {
            background-image: url('/images/CLASSROOM_BACKGROUND.svg');
            /* Adjust the path if necessary */
            background-size: cover;
            /* Cover the entire viewport */
            background-repeat: no-repeat;
            /* Prevent tiling */
            background-position: center;
            /* Center the image */
        }
    </style>


</head>

<body>
    <x-floating-alert :message="session('alert')" />
    <div class="container">
        <!-- Navbar-->
        @include('layouts.navigation')

        <div class="container mt-5">
            <h2 style ="color: white">Classroom</h2>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Room</th>
                        <th>Professor Name</th>
                        <th>Status</th>
                        <th>Time-in</th>
                        <th>Controller</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr id="room-{{ $room->id }}">
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->professor_name ?? 'N/A' }}</td>
                            <td>{{ $room->status }}</td>
                            <td>{{ $room->time_in ?? 'N/A' }}</td>
                            <td>
                                <button
                                    class="btn
                                    @if ($room->button_status == 'Remote') btn-success
                                    @elseif($room->button_status == 'Occupied') btn-warning
                                    @else btn-danger @endif
                                    btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#controlModal"
                                    {{ $room->button_status == 'Remote' ? '' : 'disabled' }}>
                                    {{ $room->button_status }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>





        <!-- INCLUDE MODALS -->
        @include('user.modal.controllerModals')





        <div class="modal fade" id="timeoutWarningModal" tabindex="-1" aria-labelledby="timeoutWarningModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="timeoutWarningModalLabel">Timeout Warning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You have exceeded the allowed time in the room. Please check out.
                    </div>
                </div>
            </div>
        </div>










        {{-- FOOTER CDN LINKS --}}

        <!--PATH: PUBLIC: BUTTON JS -->
        <script src="/scripts/button.js"></script>


        <!-- Bootstrap Bundle JS (Includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <script>
            @if (session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            @endif
        </script>
</body>

</html>
