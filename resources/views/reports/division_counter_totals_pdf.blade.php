<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Division Counter Total Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #263238;
            margin: 20px
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 4px
        }

        .meta {
            text-align: center;
            color: #607d8b;
            margin-bottom: 15px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            border: 1px solid #bdc8d1;
            padding: 7px
        }

        th,
        tfoot {
            background: #e9eef5;
            font-weight: bold
        }

        .center {
            text-align: center
        }
    </style>
</head>

<body>
    <h1>Division Counter Total Report</h1>
    <div class="meta">Generated: {{ now()->format('d M Y, h:i A') }}</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Division</th>
                <th>Counter</th>
                <th class="center">Total Submissions</th>
                <th class="center">Feedback Only</th>
                <th class="center">QR Complaints</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $index => $row)<tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->division_name }}</td>
                <td>{{ $row->counter_name }}</td>
                <td class="center">{{ $row->total_count }}</td>
                <td class="center">{{ $row->feedback_only_count }}</td>
                <td class="center">{{ $row->complaint_count }}</td>
            </tr>
            @empty<tr>
                <td colspan="6" class="center">No records found</td>
            </tr>@endforelse</tbody>
        <tfoot>
            <tr>
                <td colspan="3">Grand Total</td>
                <td class="center">{{ $grandTotals->total_count }}</td>
                <td class="center">{{ $grandTotals->feedback_only_count }}</td>
                <td class="center">{{ $grandTotals->complaint_count }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>