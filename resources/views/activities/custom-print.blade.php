<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Print - Activity Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        h1, h2 {
            text-align: center;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            table-layout: fixed; /* Ensures uniform column widths */
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 8px;
            word-wrap: break-word; /* Break long words */
            word-break: break-word; /* Ensure text wraps within cell */
            white-space: pre-wrap; /* Preserve whitespace and wrap text */
        }
        th {
            background-color: #f4f4f4;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div>
        <h1>Activity Summary</h1>
        <h2>{{ $start_date }} - {{ $end_date }}</h2>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 50%;">Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $index => $activity)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $activity->name }}</td>
                        <td>{{ $activity->date }}</td>
                        <td>{{ ucfirst($activity->status) }}</td>
                        <td>{{ $activity->comments }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button class="no-print" onclick="window.print()">Print</button>
</body>
</html>
