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
                        <tr>
                            <td>2024-03-31 12:45 PM</td>
                            <td>192.168.1.1</td>
                            <td><i class="fas fa-desktop"></i> Desktop</td>
                            <td>New York, USA</td>
                        </tr>
                        <tr>
                            <td>2024-03-30 10:15 AM</td>
                            <td>203.55.112.89</td>
                            <td><i class="fas fa-mobile-alt"></i> Mobile</td>
                            <td>London, UK</td>
                        </tr>
                        <tr>
                            <td>2024-03-29 08:30 AM</td>
                            <td>145.36.78.99</td>
                            <td><i class="fas fa-desktop"></i> Desktop</td>
                            <td>Berlin, Germany</td>
                        </tr>
                        <tr>
                            <td>2024-03-28 05:20 PM</td>
                            <td>220.145.12.88</td>
                            <td><i class="fas fa-mobile-alt"></i> Mobile</td>
                            <td>Tokyo, Japan</td>
                        </tr>
                        <tr>
                            <td>2024-03-27 02:00 PM</td>
                            <td>176.23.45.67</td>
                            <td><i class="fas fa-desktop"></i> Desktop</td>
                            <td>Paris, France</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Include Footer --}}
@include('user.footer')
