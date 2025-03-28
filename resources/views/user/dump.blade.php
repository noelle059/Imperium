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
                        <label for="switch${device.device_id}">
                            <i class="bi bi-lightbulb" id="icon${device.device_id}"></i> ${device.device_name}
                        </label>
                        <label class="switch">
                            <input type="checkbox" id="switch${device.device_id}"
                                   data-device-id="${device.device_id}"
                                   data-classroom-id="${classroomId}"
                                   data-device-name="${device.device_name}"
                                   ${checked}
                                   onclick="toggleSwitch(${device.device_id}, ${classroomId}, '${device.device_name}')">
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

            // Loop through devices and update UI
            if (devices) {
                Object.keys(devices).forEach(deviceId => {
                    const device = devices[deviceId];
                    // Update the UI with the device states
                    updateDeviceUI(deviceId, device);
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
            `classrooms/${classroomId}/devices/${deviceId}/state`); // Use deviceId, not device_name
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
