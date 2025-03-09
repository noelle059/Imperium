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


    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Units</th>
                    <th>Date and Time </th>
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
                        <td>{{ \Carbon\Carbon::parse($subject->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}
                        </td>
                        <td class="action-cell">
                            <!-- Pass subject data via data- attributes -->
                            <button class="btn gradient-button" data-bs-toggle="modal"
                                data-bs-target="#update_subject_modal" data-id="{{ $subject->id }}"
                                data-subject_code="{{ $subject->subject_code }}"
                                data-subject_name="{{ $subject->subject_name }}"
                                data-subject_units="{{ $subject->units }}">
                                UPDATE
                            </button>

                            <!-- Removing the subject from the list -->
                            <button class="btn gradient-button" type="button" data-id="{{ $subject->id }}"
                                id="RemoveSubjectButton">
                                REMOVE
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>


        </table>

    </div>


    <div style="display: flex; justify-content: flex-end; margin-top: 20px; padding-right: 20px;">
        <button class="btn gradient-button" style="display: flex; align-items: center; " type="button"
            data-bs-toggle="modal" data-bs-target="#add_subject_modal">
            <i class="fa fa-plus" style="margin-right: 5px;"></i> Add Subject
        </button>
    </div>

    <!-- Pagination links -->
    <div style="padding-left: 20px; padding-bottom: 30px;">
        {{ $subjects->links() }}
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
