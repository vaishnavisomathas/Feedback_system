<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rating Points Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background-color: #f3f6fa;
            border-bottom: 2px solid #d2dceb;
        }

        table th {
            padding: 10px;
            text-align: left;
            font-weight: 600;
            color: #243b53;
            font-size: 12px;
        }

        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #edf1f5;
            font-size: 12px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <h1>Rating Points Report</h1>

    @if($ranking->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">#</th>
                    <th style="width: 25%;">Division</th>
                    <th style="width: 25%;">Counter</th>
                    <th style="width: 20%;">Feedback Count</th>
                    <th style="width: 22%;">Average Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ranking as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->counter->division_name ?? '-' }}</td>
                        <td>{{ $item->counter->counter_name ?? '-' }}</td>
                        <td style="text-align: center;">{{ $item->total }}</td>
                        <td style="text-align: center;">{{ number_format($item->avg_rating, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center;">No data found for the selected filters.</p>
    @endif
</body>
</html>
