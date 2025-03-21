<!DOCTYPE html>
<html lang="en">
<head>
<img src="{{ public_path('images/colored_logo_with_text.png') }}" 
style="width: 150px; height: auto; display: block; margin: 0 auto; border: none;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h5>Biglang Awa Street, Cor 11th Ave, Catleya, Caloocan, 1400 Metro Manila, Philippines</h5>
    <p>Empowering educators and institutions with an intelligent, energy-efficient system for seamless classroom management and security.</p>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 15px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
    <div style="text-align:left; margin-bottom: 20px;">
<br><br>
    <p><strong>Printed Date:</strong> {{ $current_date }}</p>
</div>

</head>
<br><br>
<body>

    <h2>IMPERIUM CLASSROOM REPORT</h2>
    
    <table>
        <thead>
            <tr>
                <th>Schedule ID</th>
                <th>Classroom</th>
                <th>Professor</th>
                <th>Subject</th>
                <th>Schedule Day</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $schedule->id }}</td>
                <td>{{ $schedule->classroom ? $schedule->classroom->classroom_name : 'N/A' }}</td>
                <td>{{ $schedule->user ? $schedule->user->name : 'N/A' }}</td>
                <td>{{ $schedule->subject ? $schedule->subject->subject_name : 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->schedule_day)->format('F j, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
            </tr>
        </tbody>
    </table>
    <div style="text-align:right; margin-bottom: 20px;">
    <p><strong>Report Creator:</strong><br> {{ $name }}</p>
</div>

   
</body>
</html>
