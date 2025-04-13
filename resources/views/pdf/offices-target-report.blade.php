@props(['offices', 'targets'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offices Target</title>
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
        <h1>Offices target as of {{ now()->format('F d, Y') }}</h1>

        <table>
            <thead>
                <tr>
                    <th>PROGRAMS, PROJECTS, ACTIVITIES</th>
                    <th>PERFORMANCE INDICATORS</th>
                    @foreach($offices as $office)
                    <th>{{ $office }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($targets as $target)
                <tr>

                    <td rowspan="{{ count($target['sub_targets']) }}">
                        {{ $target['description'] }}
                    </td>

                    @if(count($target['sub_targets']) > 0)
                    <td>{{ $target['sub_targets'][0]['description'] }}</td>
                    @foreach($target['sub_targets'][0]['offices_target'] as $target_number)
                    <td>{{ $target_number['target_number'] }}</td>
                    @endforeach
                    @endif
                </tr>

                @for($i = 1; $i < count($target['sub_targets']); $i++)
                    <tr>
                    <td>{{ $target['sub_targets'][$i]['description'] }}</td>
                    @foreach($target['sub_targets'][$i]['offices_target'] as $target_number)
                    <td>{{ $target_number['target_number'] }}</td>
                    @endforeach
                    </tr>
                    @endfor
                    @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>