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

    document.querySelectorAll(".entry").forEach(button => {
        button.addEventListener("click", function () {
            let classroomId = this.getAttribute("data-id");
            entryModal.setAttribute("data-classroom-id", classroomId);
            console.log("Modal opened with Classroom ID:", classroomId);
        });
    });

    entryModal.addEventListener("show.bs.modal", function () {
        rfidLabel.style.display = "none";
        rfidLabel.textContent = "Scanning RFID...";
        enterBtn.style.display = "none";
        enterBtn.disabled = true;
        fetchProfessorSubjects();
    });

    subjectSelect.addEventListener("change", function () {
        let selectedSubject = this.value;
        let classroomId = entryModal.getAttribute("data-classroom-id");

        if (!classroomId) {
            console.error("Classroom ID is missing!");
            return;
        }

        fetch(`/check-schedule?classroom_id=${classroomId}&subject_id=${selectedSubject}`)
            .then(response => response.json())
            .then(data => {
                console.log("Check Schedule Response:", data);

                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Access Denied',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        subjectSelect.selectedIndex = 0;
                    });

                    rfidLabel.style.display = "none";
                    enterBtn.style.display = "none";
                } else {
                    enterBtn.setAttribute("data-schedule-id", data.schedule_id);

                    rfidLabel.style.display = "block";
                    enterBtn.style.display = "block";
                    enterBtn.disabled = true;

                    fetch("/get-professor-rfid")
                        .then(response => response.json())
                        .then(professorData => {
                            console.log("Professor RFID:", professorData.rfid_uid);
                            checkRFIDMatch(professorData.rfid_uid);
                        });
                }
            })
            .catch(error => console.error("Error fetching schedule:", error));
    });


    function checkRFIDMatch(professorRFID) {
        fetch("/get-rfid-from-firebase")
            .then(response => response.json())
            .then(data => {
                console.log("Fetched RFID from Firebase:", data.rfid);

                if (data.rfid) {
                    rfidLabel.textContent = `Scanned RFID: ${data.rfid}`;
                    rfidLabel.style.display = "block";

                    if (String(data.rfid).trim() !== String(professorRFID).trim()) {
                        Swal.fire({
                            icon: "error",
                            title: "Access Denied",
                            text: "RFID does not match the logged-in professor!",
                            timer: 2500,
                            showConfirmButton: false
                        });
                        enterBtn.disabled = true;
                    } else {
                        enterBtn.disabled = false;
                    }
                }
            })
            .catch(error => console.error("Error fetching RFID from Firebase:", error));
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

    document.getElementById("enterClassroom").addEventListener("click", function () {
        let professorId = "{{ auth()->user()->id }}";
        let scheduleId = enterBtn.getAttribute("data-schedule-id");
        let rfid = "{{ auth()->user()->rfid_uid }}";

        if (!scheduleId) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No valid schedule found. Please select a valid subject.",
            });
            return;
        }

        fetch("/schedule-log", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                user_id: professorId,
                schedule_id: scheduleId,
                rfid_no: rfid,
                start_time: new Date().toISOString(),
            }),
        })
        .then(response => response.text())
        .then(text => {
            console.log("Server Response:", text);
            try {
                let data = JSON.parse(text);
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Welcome",
                        text: "You may now enter the classroom.",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        let modalInstance = bootstrap.Modal.getInstance(entryModal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Something went wrong!",
                    });
                }
            } catch (e) {
                console.error("Invalid JSON response:", text);
            }
        })
        .catch(error => console.error("Error logging entry:", error));
    });
});
</script>
