<!-- Update Account Modal -->
<div class="modal fade" id="register_account_id_modal" tabindex="-1" aria-labelledby="register_account_id_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="register_account_id_modal">Update Account</h1>
            </div>

            <!-- Update Account Form -->
            <form id="UpdateAccountForm" action="{{ route('accounts.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <!-- Modal Content (Add fields for account info) -->
                    <div class="mb-3">
                        <label for="account_name" class="form-label">Account Name</label>
                        <input type="text" id="account_name" name="account_name" class="form-control outlined-input"
                            placeholder="Enter account name" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="account_email" class="form-label">Account Email</label>
                        <input type="email" id="account_email" name="account_email"
                            class="form-control outlined-input" placeholder="Enter email" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="rfid_uid" class="form-label">RFID UID</label>
                        <input type="text" id="rfid_uid" name="rfid_uid" class="form-control outlined-input"
                            placeholder="Enter RFID UID" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn gradient-button" id="UpdateAccountButton">Update
                            Account</button>
                        <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const email = button.getAttribute('data-email');
                const rfid_uid = button.getAttribute('data-rfid_uid');
                const is_activated = button.getAttribute('data-is_activated');

                // Set the values in the modal fields
                document.getElementById('account_name').value = name;
                document.getElementById('account_email').value = email;
                document.getElementById('rfid_uid').value = rfid_uid;
                document.getElementById('is_activated').value = is_activated;

                // Update the form action URL to include the ID for the PUT request
                const form = document.getElementById('UpdateAccountForm');
                form.action = form.action.replace(':id', id); // Replace :id with the actual id
            });
        });
    });
</script>
