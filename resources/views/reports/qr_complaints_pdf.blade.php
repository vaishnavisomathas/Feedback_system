<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QR Complaint Report</title>
    <style>
        @font-face {
            font-family: NotoSansTamil;
            src:url("{{ public_path('fonts/NotoSansTamil-Regular.ttf') }}") format('truetype')
        }

        body {
            font-family: NotoSansTamil, sans-serif;
            font-size: 8px;
            color: #263238
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px
        }

        .meta {
            text-align: center;
            margin-bottom: 12px;
            color: #607d8b
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            border: 1px solid #b9c5cf;
            padding: 4px;
            vertical-align: top
        }

        th {
            background: #e9eef5;
            font-weight: bold
        }

        .center {
            text-align: center
        }

        .complaint {
            width: 24%
        }
    </style>
</head>

<body>
    <h1>QR Complaint Report</h1>
    <div class="meta">Generated: {{ now()->format('d M Y, h:i A') }}</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Division / Counter</th>
                 <th>Contact</th>
                        <th>Email</th>
                <th>Vehicle</th>
                <th>Rating</th>
                <th>Status</th>
                <th class="complaint">Complaint</th>
            </tr>
        </thead>
        <tbody>@forelse($complaints as $index => $item)<tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $item->created_at?->format('d M Y') }}</td>
                <td>{{ $item->counter->division_name ?? '-' }}<br>{{ $item->counter->counter_name ?? '-' }}</td>
  <td>{{ $item->phone ?? '-' }}</td>
                        <td>{{ $item->complaint_email ?? '-' }}</td>                
                        <td>{{ $item->vehicle_number ?? '-' }}</td>
                <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$item->rating] ?? '-' }}</td>
                <td>{{ ucfirst($item->status ?? 'pending') }}</td>
                <td>{{ $item->note }}</td>
            </tr>@empty<tr>
                <td colspan="9" class="center">No QR complaints found</td>
            </tr>@endforelse</tbody>
    </table>
</body>

</html>