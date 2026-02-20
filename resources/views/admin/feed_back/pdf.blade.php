<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2, h3, p { margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Northern Provincial Department of Motor Traffic (PDMT)</h2>
    <h3>Feedback Report</h3>
    <p>Printed on: {{ $printedAt->format('d M Y, H:i') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>DS Division</th>
            <th>Counter</th>
            <th>Vehicle</th>
            <th>Phone</th>
            <th>Rating</th>
            <th>Complaint</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ratings as $i => $rating)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $rating->counter->division_name ?? '-' }}</td>
            <td>{{ $rating->counter->counter_name ?? '-' }}</td>
            <td>{{ $rating->vehicle_number }}</td>
            <td>{{ $rating->phone }}</td>
                    <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? '-' }}</td>
            <td>{{ $rating->note }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
