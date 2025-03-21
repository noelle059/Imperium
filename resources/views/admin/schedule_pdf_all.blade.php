<!DOCTYPE html>
<html lang="en">
<head>
<img src="{{ public_path('images/colored_logo_with_text.png') }}" 
style="width: 150px; height: auto; display: block; margin: 0 auto; border: none;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h5>Biglang Awa Street, Cor 11th Ave, Catleya, Caloocan, 1400 Metro Manila, Philippines</h5>
    <h5>Empowering educators and institutions with an intelligent, energy-efficient system for seamless classroom management and security.</h5>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 15px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>

<div style="text-align:left; margin-bottom: 20px;">
    <p><strong>Start Date:</strong> {{ $start_date !== 'N/A' ? \Carbon\Carbon::parse($start_date)->format('F j, Y') : 'N/A' }}</p>
    <p><strong>End Date:</strong> {{ $end_date !== 'N/A' ? \Carbon\Carbon::parse($end_date)->format('F j, Y') : 'N/A' }}</p>
    <p><strong>Printed Date:</strong> {{ $current_date }}</p>
</div>



</head>
<br>
<br>
<body>

    <h2>IMPERIUM CLASSROOM REPORT</h2>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Room No.</th>
                <th>Classroom Name</th>
                <th>Device Count</th>
                <th>Floor Level</th>
                <th>Entry Date</th>
                <th>Start Time</th>
                <th>End Time</th>

            </tr>
        </thead>
        <tbody>
    @foreach ($schedules as $schedule)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $schedule->classroom ? $schedule->classroom->classroom_name : 'N/A' }}</td>
            <td>{{ $schedule->user ? $schedule->user->name : 'N/A' }}</td>
            <td>{{ $schedule->subject ? $schedule->subject->subject_name : 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('F j, Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td> <!-- Start time -->
            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td> <!-- End time -->
        </tr>
    @endforeach
</tbody>

    </table>
    <div style="text-align:right; margin-bottom: 20px;">
    <p><strong>Report Creator:</strong><br> {{ $name }}</p>
</div>

   
</body>
</html>
