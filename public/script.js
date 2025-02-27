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

// Reference to the RFID node in Firebase
const rfidRef = ref(db, "/rfid/access");

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

function checkTimeOutWarning() {
    fetch('/get-room-status', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const now = new Date();
        const timeIn = new Date(`1970-01-01T${data.time_in}Z`);
        const diffInMinutes = (now - timeIn) / (1000 * 60);

        if (diffInMinutes > 1) {
            const warningModal = new bootstrap.Modal(document.getElementById('timeoutWarningModal'));
            warningModal.show();
        }
    })
    .catch(error => {
        console.error('Error checking room status:', error);
    });
}

// Periodically check the time difference every 30 seconds
setInterval(checkTimeOutWarning, 30000);
