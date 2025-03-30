<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Registration Form for Admin -->
                <form id="addAdminForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="idPicture" class="form-label">Upload ID Picture</label>
                        <input type="file" class="form-control" id="idPicture" name="id_picture" accept="image/*" required>
                        <span class="text-danger" id="idPictureError"></span>
                    </div>
                </form> <!-- ✅ Form closes here (without a submit button inside) -->
            </div>

            <!-- ✅ Submit Button Outside Form -->
            <div class="modal-footer">
                <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn gradient-button" id="submitAdminForm">Register Admin</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JavaScript to Submit the Form -->
<script>
    document.getElementById("submitAdminForm").addEventListener("click", function() {
        document.getElementById("addAdminForm").submit();
    });
</script>
