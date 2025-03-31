@include('admin.header')

<!-- Account-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Subject Registration</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 0;">
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; padding-right: 20px;">
        <button class="btn gradient-button add" style="display: flex; align-items: center;" type="button"
            data-bs-toggle="modal" data-bs-target="#add_subject_modal">
            <i class="fa fa-plus" style="margin-right: 5px;"></i>
        </button>
    </div>

    {{-- Table Section --}}
    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Units</th>
                    <th>Subject Added on</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr class="table-row">
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $subject->subject_code }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>{{ $subject->units }}</td>
                        <td>{{ \Carbon\Carbon::parse($subject->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>
                        <td class="action-cell">
                            <button class="btn gradient-button update" data-bs-toggle="modal"
                                data-bs-target="#update_subject_modal" data-id="{{ $subject->id }}"
                                data-subject_code="{{ $subject->subject_code }}"
                                data-subject_name="{{ $subject->subject_name }}"
                                data-subject_units="{{ $subject->units }}">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </button>

                            <button class="btn gradient-button archive" type="button" data-id="{{ $subject->id }}" id="RemoveSubjectButton">
                                <i class="fa-solid fa-box-archive"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-container" style="margin-top: 10px;">
            {{ $subjects->links() }}
        </div>
    </div>
</div>

@include('admin.footer')

@include('admin.modal.subjectModals')
@include('admin.sweetAlerts.subjectAlert')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchData(page = 1, searchValue = '') {
            $.ajax({
                url: "{{ route('subjects.index') }}",
                method: 'GET',
                data: { search: searchValue, page: page },
                success: function (response) {
                    $('.table-container').html($(response).find('.table-container').html());
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
