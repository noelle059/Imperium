import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.3/firebase-app.js";
import { getDatabase, ref, set, onValue } from "https://www.gstatic.com/firebasejs/9.9.3/firebase-database.js";

// Firebase config
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

// References to the switches in Firebase
const switchRef1 = ref(db, "/bulb1/state");
const switchRef2 = ref(db, "/bulb2/state");
const switchRef3 = ref(db, "/bulb3/state");
const switchRef4 = ref(db, "/bulb4/state");
const outlet = ref(db, "/outlet/state");

// Reference to the RFID node in Firebase
const rfidRef = ref(db, "/rfid/access");

// Function to toggle switches
window.toggleSwitch = function(switchId) {
    let state = document.getElementById(switchId).checked;
    let iconId;

    if (switchId === 'switch1') {
        iconId = 'icon1';
    } else if (switchId === 'switch2') {
        iconId = 'icon2';
    } else if (switchId === 'switch3') {
        iconId = 'icon3';
    } else if (switchId === 'switch4') {
        iconId = 'icon4';
    } else if (switchId === 'outlet') {
        iconId = 'outlet-icon';
    }

    if (state) {
        document.getElementById(iconId).classList.replace('bi-outlet', 'bi-plug-fill');
    } else {
        document.getElementById(iconId).classList.replace('bi-plug-fill', 'bi-outlet');
    }

    if (switchId === 'switch1') {
        set(switchRef1, state);
    } else if (switchId === 'switch2') {
        set(switchRef2, state);
    } else if (switchId === 'switch3') {
        set(switchRef3, state);
    } else if (switchId === 'switch4') {
        set(switchRef4, state);
    } else if (switchId === 'outlet') {
        set(outlet, state);
    }
};

// Monitor the switches' states from Firebase (to sync UI with ESP32)
onValue(switchRef1, function(snapshot) {
    document.getElementById('switch1').checked = snapshot.val();
    let iconId = 'icon1';
    if (snapshot.val()) {
        document.getElementById(iconId).classList.replace('bi-lightbulb', 'bi-lightbulb-fill');
    } else {
        document.getElementById(iconId).classList.replace('bi-lightbulb-fill', 'bi-lightbulb');
    }
});

onValue(switchRef2, function(snapshot) {
    document.getElementById('switch2').checked = snapshot.val();
    let iconId = 'icon2';
    if (snapshot.val()) {
        document.getElementById(iconId).classList.replace('bi-lightbulb', 'bi-lightbulb-fill');
    } else {
        document.getElementById(iconId).classList.replace('bi-lightbulb-fill', 'bi-lightbulb');
    }
});

onValue(switchRef3, function(snapshot) {
    document.getElementById('switch3').checked = snapshot.val();
    let iconId = 'icon3';
    if (snapshot.val()) {
        document.getElementById(iconId).classList.replace('bi-lightbulb', 'bi-lightbulb-fill');
    } else {
        document.getElementById(iconId).classList.replace('bi-lightbulb-fill', 'bi-lightbulb');
    }
});

onValue(switchRef4, function(snapshot) {
    document.getElementById('switch4').checked = snapshot.val();
    let iconId = 'icon4';
    if (snapshot.val()) {
        document.getElementById(iconId).classList.replace('bi-lightbulb', 'bi-lightbulb-fill');
    } else {
        document.getElementById(iconId).classList.replace('bi-lightbulb-fill', 'bi-lightbulb');
    }
});

onValue(outlet, function(snapshot) {
    document.getElementById('outlet').checked = snapshot.val();
    if (snapshot.val()) {
        document.getElementById('outlet-icon').classList.replace('bi-outlet', 'bi-plug-fill');
    } else {
        document.getElementById('outlet-icon').classList.replace('bi-plug-fill', 'bi-outlet');
    }
});

// RFID scanning
let isProcessingRFID = false; // Flag to prevent multiple requests
const accessState = ref(db, "/access/state");

onValue(rfidRef, function(snapshot) {
    const scannedRfid = snapshot.val();

    if (scannedRfid && !isProcessingRFID) {
        isProcessingRFID = true; // Set the flag to prevent re-calling
        console.log('RFID scanned:', scannedRfid);

        fetch('/handle-rfid-scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ rfid_uid: scannedRfid })
        })
        .then(response => response.json())
        .then(data => {
                console.log("Server response:", data); // Debugging step
                if (data.access_state !== undefined) {
                    console.log("Updating Firebase with:", data.access_state); // Debugging step
                    set(accessState, data.access_state);
                } else {
                    console.error("RFID scan failed:", data.error);
                }
                if (data.room) {
                    console.log("Updating table row for:", data.room);
                    updateTableRow(data.room);
                }
        })
        .catch(error =>{
            console.error('Error handling RFID scan:', error);
            isProcessingRFID = false;
        })
        .finally(() => {
            setTimeout(() => {
                isProcessingRFID = false;
            }, 5000);
        });
    }
});


// Function to update the table row for Room #1
function updateTableRow(room) {
    const row = document.querySelector(`#room-${room.id}`);
    if (row) {
        row.innerHTML = `
            <td>${room.room_name}</td>
            <td>${room.professor_name || 'N/A'}</td>
            <td>${room.status}</td>
            <td>${room.time_in || 'N/A'}</td>
            <td>
                <button class="btn btn-${room.controller ? 'success' : 'danger'} btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#controlModal"
                        ${room.controller ? '' : 'disabled'}>
                    ${room.controller ? 'Remote' : 'Offline'}
                </button>
            </td>
        `;
    }
}
