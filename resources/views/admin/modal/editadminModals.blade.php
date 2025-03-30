<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- ✅ Form starts -->
            <form id="editAdminForm" method="POST" action="{{ route('admin.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <input type="hidden" name="id" id="editAdminId">

                    <div class="form-group">
                        <label for="editAdminName">First Name</label>
                        <input type="text" class="form-control" id="editAdminName" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="editAdminLastName">Last Name</label>
                        <input type="text" class="form-control" id="editAdminLastName" name="last_name" required>
                    </div>

                    <div class="form-group">
                        <label for="editAdminEmail">Email</label>
                        <input type="email" class="form-control" id="editAdminEmail" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="editAdminContact">Contact Number</label>
                        <input type="text" class="form-control" id="editAdminContact" name="contact_number" required>
                    </div>

                    <!-- ✅ Image Upload Field (Matches Add Admin Modal) -->
                    <div class="mb-3">
                        <label for="editAdminPicture" class="form-label">Upload ID Picture</label>
                        <input type="file" class="form-control" id="editAdminPicture" name="id_picture" accept="image/*">
                        <span class="text-danger" id="idPictureError"></span>
                        <!-- ✅ Image Preview -->
                        <img id="previewImage" src="" alt="Current Image" class="img-thumbnail mt-2" style="max-width: 100px; display: none;">
                    </div>
                </div>
            </form> <!-- ✅ Form ends here -->
            
            <!-- ✅ Buttons outside the form -->
            <div class="modal-footer">
                <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn gradient-button" id="saveEditAdmin">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JavaScript to Handle Form Submission & Image Preview -->
<script>
    document.getElementById("saveEditAdmin").addEventListener("click", function() {
        document.getElementById("editAdminForm").submit();
    });

    document.getElementById("editAdminPicture").addEventListener("change", function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let preview = document.getElementById("previewImage");
            preview.src = reader.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
