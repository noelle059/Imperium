{{-- Include Header --}}
@include('user.header')

{{-- Include Navigation --}}
@include('user.navigationbar')


<div class="page-header">
    <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="h5 no-margin-bottom" style="margin-left: 20px;">ACCOUNT PROFILE</h2>
    </div>
</div>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Login History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Date & Time</th>
                            <th>IP Address</th>
                            <th>Device</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($logs as $index => $log)
                    <tr>
                    <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>
                    <td>{{ $log->ip_address }}</td> <!-- Displaying the IP address here -->
                    <td>{{ $log->device_info }}</td>
                    <td>{{ $log->location }}</td>




                    </tr>
                @endforeach
            </tbody>


                </table>
            </div>
        </div>
    </div>
</div>

{{-- Include Footer --}}
@include('user.footer')
