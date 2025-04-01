@include('admin.header')

<!-- Account-->
<div class="page-content">

    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Admin Account Registration</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>


    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px;">
    <button class="btn gradient-button add" type="button" data-bs-toggle="modal" data-bs-target="#addAdminModal">
        <i class="fa fa-plus" style="margin-right: 5px;"></i> Add Admin
    </button>
</div>
@include('admin.modal.addadminModals')
@include('admin.modal.editadminModals')

    <div class="table-container">
    <table id="uniqueTable" class="styled-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Picture</th>
            <th>Name</th>
            <th>Email</th>
            <th>Entry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admin_accounts as $index => $admin_account)
        <tr class="table-row" data-archived="{{ $admin_account->archive_status }}">
        <td>{{ $loop->iteration }}</td> <!-- Auto-increment number -->
       <td>
    @php
        $idPicture = $admin_account->id_picture;
        $filename = basename($idPicture);
        $localImagePath = public_path('uploads/id_pictures/' . $filename);
    @endphp

    @if (Str::startsWith($idPicture, 'http'))
        <!-- If id_picture is a Google URL -->
        <img src="{{ $idPicture }}" alt="Profile Picture" class="img-fluid" style="width: 50px; height: auto;">
    @elseif (!empty($idPicture) && file_exists($localImagePath))
        <!-- If id_picture is a local file stored in 'uploads/id_pictures/' -->
        <img src="{{ asset('uploads/id_pictures/' . $filename) }}" alt="Profile Picture" class="img-fluid" style="width: 50px; height: auto;">
    @else
        <!-- Fallback to default avatar if no valid image is found -->
        <img src="{{ asset('uploads/default-avatar.jpg') }}" alt="Default Avatar" class="img-fluid" style="width: 50px; height: auto;">
    @endif
</td>



                <td>{{ $admin_account->name }}</td>
                <td>{{ $admin_account->email }}</td>
                <td>{{ \Carbon\Carbon::parse($admin_account->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>

                <td class="action-cell">
                    <!-- Edit Admin Button -->
                    <button class="btn gradient-button update" type="button"
                        data-id="{{ $admin_account->id }}"
                        data-name="{{ $admin_account->name }}"
                        data-last_name="{{ $admin_account->last_name }}"
                        data-email="{{ $admin_account->email }}"
                        data-contact_number="{{ $admin_account->contact_number }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editAdminModal">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    </button>

                    <button class="btn gradient-button archive remove-admin" type="button"
    data-id="{{ $admin_account->id }}">
    <i class="fa-solid fa-box-archive"></i>
</button>


                </td>
            </tr>
        @endforeach
    </tbody>
</table>



        <!-- Pagination controls -->
        <div class="pagination-container" style="margin-top: 10px;">
            {{ $admin_accounts->links() }}
        </div>
    </div>


    {{-- INCLUDE FOOTER --}}
    @include('admin.footer')

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let table = document.getElementById('uniqueTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let matchFound = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        let cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(filter) > -1) {
                            matchFound = true;
                        }
                    }
                }

                if (matchFound) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    </script>

    <script>

document.querySelectorAll('.update').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('editAdminId').value = this.dataset.id;
        document.getElementById('editAdminName').value = this.dataset.name;
        document.getElementById('editAdminLastName').value = this.dataset.last_name;
        document.getElementById('editAdminEmail').value = this.dataset.email;
        document.getElementById('editAdminContact').value = this.dataset.contact_number;
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".remove-admin").forEach(button => {
        button.addEventListener("click", function () {
            let adminId = this.dataset.id;
            Swal.fire({
                title: "Are you sure?",
                text: "This admin will be moved to archive!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "",
                cancelButtonColor: "",
                confirmButtonText: "Yes, archive it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ url('/admin/remove') }}", { // ✅ Use POST instead of appending ID in URL
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id: adminId }) // ✅ Send ID as JSON
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Archived!", "Admin has been archived.", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Error!", data.message || "Something went wrong.", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                        Swal.fire("Error!", "Failed to send request.", "error");
                    });
                }
            });
        });
    });
});




    </script>



