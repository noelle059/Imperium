<!DOCTYPE html>
<html lang="en">
<head>
    <img src="{{ public_path('images/colored_logo_with_text.png') }}" 
         style="width: 120px; height: auto; display: block; margin: 0 auto; border: none;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <h5 style="margin-bottom: 3px;">Biglang Awa Street, Cor 11th Ave, Catleya, Caloocan, 1400 Metro Manila, Philippines</h5>
    <p style="margin-bottom: 10px; font-size: 10px; font-weight: bold;"">Empowering educators and institutions with an intelligent, energy-efficient system for seamless classroom management and security.</p>

    <style>
        body { font-family: Arial, sans-serif; text-align: center; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; white-space: nowrap; }
        th { background-color: #f2f2f2; font-size: 11px; }
        p { margin: 2px 0; }
    </style>

    <div style="text-align:left; margin-bottom: 10px;">
        <p><strong>Printed Date:</strong> {{ $current_date }}</p>
    </div>
</head>

<body>
    <h4 style="margin-bottom: 5px;">IMPERIUM CLASSROOM REPORT</h4>
    
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

    <div style="text-align:right; margin-top: 10px;">
        <p><strong>Report Creator:</strong> {{ $name }}</p>
    </div>
</body>
</html>
