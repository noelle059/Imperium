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


    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin_accounts as $index => $admin_account)
                    <tr class="table-row">
                        <td>{{ $loop->iteration }}</td> <!-- Auto-increment number -->
                        <td>
                            @if (filter_var($admin_account->id_picture, FILTER_VALIDATE_URL))
                                <!-- If the id_picture is a URL, just output the URL -->
                                <img src="{{ $admin_account->id_picture }}" alt="ID Picture"
                                    style="width: 50px; height: auto;">
                            @else
                                <!-- If the id_picture is a local file, use asset() to reference it -->
                                <img src="{{ asset('uploads/id_pictures/' . $admin_account->id_picture) }}"
                                    alt="ID Picture" style="width: 50px; height: auto;">
                            @endif
                        </td>

                        <td>{{ $admin_account->name }}</td>
                        <td>{{ $admin_account->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($admin_account->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}
                        </td>

                        <td class="action-cell">


                            <!-- Adding ID from the professor list -->
                            <button class="btn gradient-button" type="button" data-id="{{ $admin_account->id }}"
                                data-name="{{ $admin_account->name }}" data-email="{{ $admin_account->email }}"
                                data-rfid_uid="{{ $admin_account->rfid_uid }}"
                                data-is_activated="{{ $admin_account->is_activated }}" data-bs-toggle="modal"
                                data-bs-target="#register_account_id_modal">
                                UPDATE
                            </button>

                            <!-- Removing the subject from the list -->
                            <button class="btn gradient-button" type="button" data-id="{{ $admin_account->id }}"
                                id="RemoveAccountButton">
                                REMOVE
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



    <!-- Add your search script below -->
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
