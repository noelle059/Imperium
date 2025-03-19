@include('admin.header')

<div class="page-content">
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Classroom Report</h2>

            <div style="display: flex; align-items: center;">
                <i class="icon-magnifying-glass-browser" style="cursor: pointer; padding-right: 5px;"></i>
                <input type="date" id="searchInput" placeholder=" Search..."
                    style="border: 1px solid #ccc; background-color: #f0f0f0; color: #123524; height: 30px; padding: 0; margin-right: 10px;">
                <button onclick="resetSearch()" class="btn gradient-button">Reset</button>
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 10px; padding-right: 20px;">
        <a href="#" onclick="printAll()" class="btn gradient-button">
            <i class="fa-solid fa-file-pdf"></i> PRINT ALL
        </a>
    </div>

    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>Room No.</th>
                    <th>Classroom Name</th>
                    <th>Device Count</th>
                    <th>Floor Level</th>
                    <th>Entry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classrooms as $index => $classroom)
                    @if ($classroom->archive_status == 1)
                        <tr class="table-row">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $classroom->classroom_name }}</td>
                            <td>{{ $classroom->devices_count }}</td>
                            <td>{{ $classroom->floor ? $classroom->floor->floor_name : 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($classroom->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>
                            <td class="action-cell">
                                <a href="{{ route('classrooms.print', $classroom->id) }}" class="btn gradient-button">
                                    <i class="fa-solid fa-file-pdf"></i> PRINT
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @include('admin.footer')
</div>

<script>
    document.getElementById('searchInput').addEventListener('change', function () {
        let filter = this.value;
        let table = document.getElementById('uniqueTable');
        let rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            let cell = rows[i].getElementsByClassName('entry-date')[0];
            let matchFound = cell && cell.textContent === filter;
            rows[i].style.display = matchFound ? '' : 'none';
        }
    });

    function resetSearch() {
        document.getElementById('searchInput').value = "";
        let rows = document.getElementById('uniqueTable').getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            rows[i].style.display = '';
        }
    }

    function printAll() {
        let filter = document.getElementById('searchInput').value;
        let url = "{{ route('classrooms.printAll') }}";
        if (filter) {
            url += "?date=" + filter;
        }
        window.location.href = url;
    }
</script>