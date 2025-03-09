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
                        <input type="text" id="account_name" name="account_name" class="form-control"
                            placeholder="Enter account name" disabled>
                    </div>


                    <div class="mb-3">
                        <label for="account_email" class="form-label">Account Email</label>
                        <input type="email" id="account_email" name="account_email" class="form-control"
                            placeholder="Enter email" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="rfid_uid" class="form-label">Account Number</label>
                        <input type="text" id="rfid_uid" name="rfid_uid" class="form-control"
                            placeholder="Scan your RFID Card">
                    </div>

                </div>
            </form>

            <div class="modal-footer">
                <button type="submit" class="btn gradient-button" id="UpdateAccountButton">Update
                    Account</button>
                <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>



    <script>
        // Attach event listener to each Update button
        document.querySelectorAll('[data-bs-target="#register_account_id_modal"]').forEach(button => {
            button.addEventListener('click', function() {
                const professorId = this.getAttribute('data-id'); // Get professor ID
                const professorName = this.getAttribute('data-name');
                const professorEmail = this.getAttribute('data-email');
                const professorRfidUid = this.getAttribute('data-rfid_uid');

                // Update the form action to include the professor's ID
                const formAction = `{{ route('accounts.update', '') }}/${professorId}`;
                document.getElementById('UpdateAccountForm').action = formAction;

                // Populate the modal fields with the professor's data
                document.getElementById('account_name').value = professorName;
                document.getElementById('account_email').value = professorEmail;
                document.getElementById('rfid_uid').value = professorRfidUid;
            });
        });

        document.getElementById('UpdateAccountButton').addEventListener('click', function() {
            document.getElementById('UpdateAccountForm').submit();
        });
    </script>
