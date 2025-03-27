<!DOCTYPE html>
<html lang="en">
<head>
    <img src="{{ public_path('images/colored_logo_with_text.png') }}" 
         style="width: 150px; height: auto; display: block; margin: 0 auto; border: none;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h5 style="margin: 5; line-height: 1;">
    Biglang Awa Street, Cor 11th Ave, Catleya, Caloocan, 1400 Metro Manila, Philippines
</h5>
<h5 style="margin: 5; line-height: 1;">
    Empowering educators and institutions with an intelligent, energy-efficient system for seamless classroom management and security.
</h5>


    <style>
        body { font-family: Arial, sans-serif; text-align: center; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; white-space: nowrap; }
        th { background-color: #f2f2f2; font-size: 11px; }
        p { margin: 2px 0; }
    </style>

    <div style="text-align:left; margin-bottom: 10px;">
        <p><strong>Start Date:</strong> {{ $start_date !== 'N/A' ? \Carbon\Carbon::parse($start_date)->format('F j, Y') : 'N/A' }}</p>
        <p><strong>End Date:</strong> {{ $end_date !== 'N/A' ? \Carbon\Carbon::parse($end_date)->format('F j, Y') : 'N/A' }}</p>
        <p><strong>Printed Date:</strong> {{ $current_date }}</p>
    </div>
</head>

<body>
    <h4 style="margin-bottom: 5px;">IMPERIUM CLASSROOM REPORT</h4>

    <table>
        <thead>
            <tr>
                <th>Room No.</th>
                <th>Classroom Name</th>
                <th>Professor Name</th>
                <th>Subject</th>
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
                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align:right; margin-top: 10px;">
        <p><strong>Report Creator:</strong> {{ $name }}</p>
    </div>
</body>
</html>
