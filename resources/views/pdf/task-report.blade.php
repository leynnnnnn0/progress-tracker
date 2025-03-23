@props([
'targets',
'offices',
'filters',
'users',
'selectedColumns' => []
])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Commitment and Review</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        p {
            font-size: 12px;
        }

        h1 {
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        /* Replace flexbox with table layouts */
        .header-table {
            width: 100%;
            margin: 0 auto;
            padding: 0 100px;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            border: none;
            padding: 5px;
            width: 50%;
        }

        .bold {
            font-weight: bold;
        }

        span,
        .text-small {
            font-size: 12px;
            display: block;
            margin-bottom: 5px;
        }

        .spacing {
            margin-top: 10px;
        }

        /* Table styles */
        .table-container {
            width: 100%;
            height: auto;
            border: 1px solid rgba(128, 128, 128, 0.2);
            margin: 20px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .data-table th {
            background-color: #f9fafb;
            font-weight: bold;
        }

        .section-header {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .target-row td {
            background-color: #f9fafb;
        }

        .subrating-row td {
            background-color: #f9fafb;
        }

        .final-ratings td {
            background-color: #f9fafb;
        }

        /* Signature section */
        .footer-table {
            width: 100%;
            margin: 0 auto;
            padding: 0 100px;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: top;
            border: none;
            padding: 5px;
            width: 50%;
        }
    </style>
</head>

<body>
    <div>
        <h1 class="text-center">DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW</h1>
        <p class="text-center">I, FULL NAME HERE, POSITION and OFFICIAL DESIGNATION of the
            OFFICE NAME, commit to deliver and agree to be rated on the
            attainment of following targets in accordance with the
            indicated measure for the period (January - June
            2025) </p>

        <!-- Replace flex layout with table layout -->
        <table class="header-table">
            <tr>
                <td>
                    <span class="bold">Approved By:</span>
                    <span>Name:</span>
                    <span>Position:</span>
                    <span>Date:</span>
                </td>
                <td>
                    <span>Name of Employee:</span>
                    <span>Date:</span>
                    <span class="spacing bold">Rating Scale:</span>
                    <span>5 - Outstanding</span>
                    <span>4 - Very Satisfactory</span>
                    <span>3 - Satisfactory</span>
                    <span>2 - Unsatisfactory</span>
                    <span>1 - Poor</span>
                </td>
            </tr>
        </table>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>PROGRAMS, PROJECTS, ACTIVITIES</th>
                        <th>PERFORMANCE INDICATORS</th>
                        @if (in_array(3, $selectedColumns))
                        <th>TARGET NUMBER</th>
                        @endif
                        @if (in_array(4, $selectedColumns))
                        <th>SUCCESS INDICATORS (TARGETS + MEASURES)</th>
                        @endif
                        @if (in_array(5, $selectedColumns))
                        <th>INDIVIDUAL ACCOUNTABLE</th>
                        @endif
                        @if (in_array(6, $selectedColumns))
                        <th>ACTUAL ACCOMPLISHMENTS NUMBER</th>
                        @endif
                        @if (in_array(7, $selectedColumns))
                        <th>ACTUAL ACCOMPLISHMENTS</th>
                        @endif
                        @if (in_array(8, $selectedColumns))
                        <th colspan="4">
                            RATING
                        </th>
                        @endif
                        @if (in_array(9, $selectedColumns))
                        <th>REMARK</th>
                        @endif
                        @if (in_array(10, $selectedColumns))
                        <th>LINK TO EVIDENCE</th>
                        @endif
                        @if (in_array(11, $selectedColumns))
                        <th>PMT REMARK</th>
                        @endif
                    </tr>

                    @if(in_array(8, $selectedColumns))
                    <tr>
                        <th colspan="7"></th>
                        <th>Q</th>
                        <th>T</th>
                        <th>E</th>
                        <th>AVE</th>
                        <th colspan="4"></th>
                    </tr>
                    @endif

                    <tr class="section-header">
                        <th colspan="14"> CORE FUNCTIONS (75%) RESEARCH AND EXTENSION </th>
                    </tr>
                    <tr class="section-header">
                        <th colspan="14">
                            Development Goal 1: Challenge Innovation by
                            Expanding Academic and Research Programs
                        </th>
                    </tr>
                    <tr class="section-header">
                        <th colspan="14">
                            Objective 2. (Research). Objective 2. (Research) To
                            Enhance Research Productivity Contributing To
                            Sustainable Development
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @if(isset($targets[75]) && count($targets[75]) > 0)
                    @foreach($targets[75] as $target)
                    <tr class="target-row">
                        <td rowspan="{{ count($target['sub_targets']) + 1 }}">
                            {{ $target['description'] }}
                        </td>
                    </tr>
                    @foreach($target['sub_targets'] as $sub_target)
                    <tr>
                        <td>{{ $sub_target['description'] }}</td>
                        @foreach($sub_target['user_tasks'] as $user_task)
                        <td>{{ $user_task }}</td>
                        @endforeach
                        <td>
                            <!-- No button in PDF -->
                            Edit
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endif

                    @if(in_array(8, $selectedColumns))
                    <tr class="subrating-row">
                        <td colspan="7"></td>
                        <td colspan="4">SUBRATING: </td>
                        <td colspan="4"></td>
                    </tr>
                    @endif

                    <tr class="section-header">
                        <th colspan="14"> STRATEGIC FUNCTIONS (15%) </th>
                    </tr>

                    @if(isset($targets[15]) && count($targets[15]) > 0)
                    @foreach($targets[15] as $target)
                    <tr class="target-row">
                        <td rowspan="{{ count($target['sub_targets']) + 1 }}">
                            {{ $target['description'] }}
                        </td>
                    </tr>
                    @foreach($target['sub_targets'] as $sub_target)
                    <tr>
                        <td>{{ $sub_target['description'] }}</td>
                        @foreach($sub_target['user_tasks'] as $user_task)
                        <td>{{ $user_task }}</td>
                        @endforeach
                        <td>
                            <!-- No button in PDF -->
                            Edit
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endif

                    @if(in_array(8, $selectedColumns))
                    <tr class="subrating-row">
                        <td colspan="7"></td>
                        <td colspan="4">SUBRATING: </td>
                        <td colspan="4"></td>
                    </tr>
                    @endif

                    <tr class="section-header">
                        <th colspan="15"> STRATEGIC FUNCTIONS (10%) </th>
                    </tr>

                    @if(isset($targets[10]) && count($targets[10]) > 0)
                    @foreach($targets[10] as $target)
                    <tr class="target-row">
                        <td rowspan="{{ count($target['sub_targets']) + 1 }}">
                            {{ $target['description'] }}
                        </td>
                    </tr>
                    @foreach($target['sub_targets'] as $sub_target)
                    <tr>
                        <td>{{ $sub_target['description'] }}</td>
                        @foreach($sub_target['user_tasks'] as $user_task)
                        <td>{{ $user_task }}</td>
                        @endforeach
                        <td>
                            <!-- No button in PDF -->
                            Edit
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endif

                    @if(in_array(8, $selectedColumns))
                    <tr class="subrating-row">
                        <td colspan="7"></td>
                        <td colspan="4">SUBRATING: </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr class="final-ratings">
                        <td colspan="7"></td>
                        <td colspan="4">Core: </td>
                        <td colspan="4"></td>
                    </tr>
                    <tr class="final-ratings">
                        <td colspan="7"></td>
                        <td colspan="4">Strategic: </td>
                        <td colspan="4"></td>
                    </tr>
                    <tr class="final-ratings">
                        <td colspan="7"></td>
                        <td colspan="4">Support: </td>
                        <td colspan="4"></td>
                    </tr>
                    <tr class="final-ratings">
                        <td colspan="7"></td>
                        <td colspan="4">Final Ave: </td>
                        <td colspan="4"></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Replace flex layout with table layout for the footer -->
        <table class="footer-table">
            <tr>
                <td>
                    <span>Name and Signature of Ratee:</span>
                    <span>Position:</span>
                    <span>Date:</span>
                </td>
                <td>
                    <span>Final Rating by:</span>
                    <span>Position:</span>
                    <span>Date:</span>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>