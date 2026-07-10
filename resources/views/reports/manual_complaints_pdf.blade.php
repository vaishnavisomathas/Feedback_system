<!DOCTYPE html>
<html lang="ta">

<head>
    <meta charset="UTF-8">

    <title>Manual Complaint Report</title>

    <style>
        @font-face {
            font-family: 'NotoSansTamil';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/NotoSansTamil-Regular.ttf') }}")
                format('truetype');
        }

        @font-face {
            font-family: 'NotoSansTamil';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/NotoSansTamil-Bold.ttf') }}")
                format('truetype');
        }

        body {
            font-family: 'NotoSansTamil', sans-serif;
            font-size: 9px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #e9eef5;
            font-weight: bold;
        }

        th,
        td {
            font-family: 'NotoSansTamil', sans-serif;
            border: 1px solid #ccd5df;
            padding: 5px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Manual Complaint Report</h1>

    <p>
        Generated: {{ now()->format('d M Y, h:i A') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Source</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Vehicle</th>
                <th>Complaint</th>
            </tr>
        </thead>

        <tbody>
            @forelse($complaints as $index => $item)
                <tr>
                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ optional($item->received_at)->format('d M Y') ?? '-' }}
                    </td>

                    <td>
                        {{ $item->sourceSetting->name ?? $item->source ?? '-' }}
                    </td>

                    <td>
                        {{ $item->complainant_name ?? '-' }}
                    </td>

                    <td>
                        {{ $item->phone ?? '-' }}
                    </td>

                    <td>
                        {{ $item->vehicle_number ?? '-' }}
                    </td>

                    <td>
                        {{ $item->complaint }}
                    </td>

               
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="center">
                        No manual complaints found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>