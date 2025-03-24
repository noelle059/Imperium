{{-- Include Header --}}
@include('user.header')

{{-- Include Header --}}
@include('user.navigationbar')

<div class="page-header">
    <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="h5 no-margin-bottom" style="margin-left: 20px;">ACCOUNT PROFILE</h2>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow-sm border-3">
        <div class="card-header bg-white text-center">
            <h5 class="text-white ali fw-bold bg-success py-2 px-4 d-inline-block rounded">PERSONAL INFORMATION</h5>
        </div>

        <div class="card-body">
            <div class="row g-4 align-items-center">
                <div class="col-md-3 text-center">
                    <img src="{{ asset('images/avatar-1.jpg') }}" class="rounded-circle img-fluid" alt="Profile Picture" style="width: 120px; height: 120px;">
                    <div class="mt-3 d-grid gap-2">
                        <button class="btn btn-secondary btn-sm">UPLOAD IMAGE</button>
                        <button class="btn btn-success btn-sm" id="editProfileBtn">EDIT PROFILE</button>
                        <button class="btn btn-success btn-sm" id="changePassBtn">CHANGE PASSWORD</button>
                        <button class="btn btn-primary btn-sm" id="saveProfileBtn" style="display: none;">SAVE CHANGES</button>
                        <button class="btn btn-danger btn-sm" id="cancelEditBtn" style="display: none;">CANCEL</button>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control bg-light" value="" id="firstName" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control bg-light" value="" id="lastName" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control bg-light" value="" id="username" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gender</label>
                            <input type="text" class="form-control bg-light" value="" id="gender" disabled>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control bg-light" value="" id="email" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="text" class="form-control bg-light" value="" id="phoneNumber" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Role</label>
                            <input type="text" class="form-control bg-secondary text-white" value="Professor" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-3 mt-4">
        <div class="card-header bg-white text-center">
            <h5 class="text-white ali fw-bold bg-success py-2 px-4 d-inline-block rounded">SUBJECT INFORMATION</h5>
        </div>

        <div class="card-body w-100">
            <div style="overflow-x: auto;">
                <table class="table table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Units</th>
                            <th>Classroom</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Schedule Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>NSTP 122</td>
                            <td>CIVIC WELFARE TRAINING SERVICES 2</td>
                            <td>3</td>
                            <td>COM-LOVE 1</td>
                            <td>08:00 AM</td>
                            <td>10:00 AM</td>
                            <td>Monday</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editBtn = document.getElementById("editProfileBtn");
        const saveBtn = document.getElementById("saveProfileBtn");
        const cancelBtn = document.getElementById("cancelEditBtn");
        const inputs = document.querySelectorAll(".form-control");

        let originalValues = {};

        editBtn.addEventListener("click", function () {
            inputs.forEach(input => {
                if (!input.classList.contains("bg-secondary")) {
                    originalValues[input.id] = input.value;
                    input.removeAttribute("disabled");
                    input.classList.add("border-success");
                }
            });

            editBtn.style.display = "none";
            saveBtn.style.display = "inline-block";
            cancelBtn.style.display = "inline-block";
        });

        cancelBtn.addEventListener("click", function () {
            inputs.forEach(input => {
                if (!input.classList.contains("bg-secondary")) {
                    input.setAttribute("disabled", "true");
                    input.classList.remove("border-success");
                    input.value = originalValues[input.id];
                }
            });

            editBtn.style.display = "inline-block";
            saveBtn.style.display = "none";
            cancelBtn.style.display = "none";
        });

        saveBtn.addEventListener("click", function () {
            inputs.forEach(input => {
                input.setAttribute("disabled", "true");
                input.classList.remove("border-success");
            });

            editBtn.style.display = "inline-block";
            saveBtn.style.display = "none";
            cancelBtn.style.display = "none";

            alert("Profile updated successfully!");
        });
    });
</script>

{{-- Include Footer --}}
@include('user.footer')

</body>
</html>
