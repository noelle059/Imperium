@include('admin.header')

<div class="page-content">
    <div class="page-header">
        <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="h5 no-margin-bottom">Admin Logs</h2>
        </div>
    </div>

    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Admin Name</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $index => $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->message }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination controls -->
        @if ($logs->total() > 10)
            <div class="pagination-container" style="margin-top: 10px;">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

@include('admin.footer')
