@props(['offices'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offices Final Average</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Target accomplished as of {{ now()->format('F d, Y') }}</h1>

        <table>
            <thead>
                <th>ID</th>
                <th>Office</th>
                <th>Office Code</th>
                <th>Final Average</th>
            </thead>
            <tbody>
                @foreach($offices as $office)
                <tr>
                    <td>{{ $office['id'] }}</td>
                    <td>{{ $office['name'] }}</td>
                    <td>{{ $office['office_code'] }}</td>
                    <td>{{ $office['final_average'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>