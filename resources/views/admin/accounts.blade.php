@include('admin.header')

<!-- Account-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Professor Account Registration</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>

    <div id="tableSection">
        <div class="table-container">
            <table id="uniqueTable" class="styled-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pictures</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account No.</th>
                        <th>Status</th>
                        <th>Entry Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($professors as $index => $professor)
                        <tr class="table-row">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if (filter_var($professor->id_picture, FILTER_VALIDATE_URL))
                                    <img src="{{ $professor->id_picture }}" alt="ID Picture"
                                        style="width: 50px; height: auto;">
                                @else
                                    <img src="{{ asset('uploads/id_pictures/' . $professor->id_picture) }}" alt="ID Picture"
                                        style="width: 50px; height: auto;">
                                @endif
                            </td>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->email }}</td>
                            <td>{{ $professor->rfid_uid ?? 'N/A' }}</td>
                            <td>{{ $professor->is_activated ? 'Registered' : 'Pending Activation' }}</td>
                            <td>{{ \Carbon\Carbon::parse($professor->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>

                            <td class="action-cell">
                                <button class="btn gradient-button update" type="button" data-id="{{ $professor->id }}"
                                    data-name="{{ $professor->name }}" data-email="{{ $professor->email }}"
                                    data-rfid_uid="{{ $professor->rfid_uid }}"
                                    data-is_activated="{{ $professor->is_activated }}" data-bs-toggle="modal"
                                    data-bs-target="#register_account_id_modal">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </button>

                                <button class="btn gradient-button archive" type="button" data-id="{{ $professor->id }}"
                                    id="RemoveAccountButton">
                                    <i class="fa-solid fa-box-archive"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-container" style="margin-top: 10px;">
                {{ $professors->links() }}
            </div>
        </div>
    </div>

</div>

@include('admin.footer')
@include('admin.modal.accountModals')
@include('admin.sweetAlerts.accountAlert')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchData(page = 1, searchValue = '') {
            $.ajax({
                url: "{{ route('accounts') }}",
                method: 'GET',
                data: { search: searchValue, page: page },
                success: function (response) {
                    $('#tableSection').html($(response.html).find('#tableSection').html());
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }

        $('#searchInput').on('keyup', function () {
            let searchValue = $(this).val();
            fetchData(1, searchValue);
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let searchValue = $('#searchInput').val();
            fetchData(page, searchValue);
        });
    });
</script>
