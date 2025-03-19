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

    <h2>Classroom Monitoring Report</h2>

    <table>
        <thead>
            <tr>
                <th>Room No.</th>
                <th>Classroom Name</th>
                <th>Device Count</th>
                <th>Floor Level</th>
                <th>Entry Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classrooms as $classroom)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $classroom->classroom_name }}</td>
                    <td>{{ $classroom->devices_count }}</td>
                    <td>{{ $classroom->floor ? $classroom->floor->floor_name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($classroom->created_at)->format('F j, Y \a\t h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
