<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAdminForm" method="POST" action="{{ route('admin.update') }}">
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
                </div>
            </form>
            <div class="modal-footer">
                    <button type="submit" class="btn gradient-button">Save Changes</button>
                    <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Cancel</button>
                </div>
        </div>
    </div>
</div>
