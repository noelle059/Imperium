<div class="modal fade" id="entryModal" tabindex="-1" aria-labelledby="entryModalLabel" aria-hidden="true" data-classroom-id="{{ $classroom->id ?? '' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="entryModalLabel">Access Classroom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <label class="fw-bold">Access Classroom:</label>

                <select id="subjectSelect" class="form-select mt-3 subject-select">
                    <option selected disabled>Loading subjects...</option>
                </select>

                <label id="rfidLabel" class="mt-3 fw-bold text-success" style="display: none;">
                    Please scan your RFID card to enter the classroom.
                </label>

                <button id="enterClassroom" class="btn btn-outline-success mt-3 w-100" style="display: none;">
                    ENTER
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let entryModal = document.getElementById("entryModal");
    let subjectSelect = document.getElementById("subjectSelect");
    let rfidLabel = document.getElementById("rfidLabel");
    let enterBtn = document.getElementById("enterClassroom");


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

    function checkRzFIDMatch(professorRFID) {
        const superAdminRFID = "23b28d14"; // Define the super admin RFID
        fetch("/get-rfid")
            .then(response => response.json())
            .then(data => {
                console.log("Fetched RFID from firebase:", data.rfid);
                if (data.rfid) {
                    rfidLabel.textContent = `Scanned RFID: ${data.rfid}`;
                    rfidLabel.style.display = "block";

                    const scannedRFID = String(data.rfid).trim();

                    if (scannedRFID === String(professorRFID).trim() || scannedRFID === superAdminRFID) {
                        // Allow access
                        enterBtn.disabled = false;
                    } else {
                        // Deny access
                        Swal.fire({
                            icon: "error",
                            title: "Access Denied",
                            text: "RFID does not match the logged-in professor or Super Admin!",
                            timer: 2500,
                            showConfirmButton: false
                        });
                        enterBtn.disabled = true;
                        updateAccessState(false);
                    }
                }
            })
            .catch(error => console.error("Error fetching RFID:", error));
    }


    function fetchProfessorSubjects() {
        fetch("/professor/subjects")
            .then(response => response.json())
            .then(subjects => {
                subjectSelect.innerHTML = '<option selected disabled>Select Subject</option>';

                subjects.forEach(subject => {
                    let option = document.createElement("option");
                    option.value = subject.id;
                    option.textContent = subject.subject_name;
                    subjectSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching subjects:", error));
    }





});
</script>
