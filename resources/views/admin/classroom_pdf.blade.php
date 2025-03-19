<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Report</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Classroom Report</h2>
    
    <table>
        <tr>
            <th>Room No.</th>
            <td>{{ $classroom->id }}</td>
        </tr>
        <tr>
            <th>Classroom Name</th>
            <td>{{ $classroom->classroom_name }}</td>
        </tr>
        <tr>
            <th>Device Count</th>
            <td>{{ $classroom->devices_count }}</td>
        </tr>
        <tr>
            <th>Floor Level</th>
            <td>{{ $classroom->floor->floor_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Entry Date</th>
            <td>{{ \Carbon\Carbon::parse($classroom->created_at)->timezone('Asia/Manila')->format('F j, Y \a\t h:i A') }}</td>
        </tr>
    </table>

</body>
</html>
