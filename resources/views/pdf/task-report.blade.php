@props([
'targets',
'selectedColumns' => [],
'full_name',
'office_name',
'approved_by_name',
'approved_by_position',
'ratee_name',
'ratee_position',
'final_rating_by_name',
'final_rating_by_position',
'date',
'name_of_employee',
'date_range'
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

        @media print {
            .data-table {
                page-break-inside: auto;
            }

            .data-table thead {
                display: table-header-group !important;
            }

            .data-table tfoot {
                display: table-footer-group;
            }

            .data-table thead tr {
                position: static;
            }

            .data-table::after {
                content: "";
                display: block;
                page-break-before: always;
                page-break-after: always;
            }

            @page {
                margin-top: 0;
            }

            .section-header {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body>
    <div>
        <h1 class="text-center">DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW</h1>
        <p class="text-center">I, {{ $full_name }} of the
            {{$office_name }}, commit to deliver and agree to be rated on the
            attainment of following targets in accordance with the
            indicated measure for the period ({{ $date_range }})
        </p>

        <table class="header-table">
            <tr>
                <td>
                    <span class="bold">Approved By:</span>
                    <span>Name: {{ $approved_by_name }}</span>
                    <span>Position: {{ $approved_by_position }}</span>
                    <span>Date: {{ $date }}</span>
                </td>
                <td>
                    <span>Name of Employee: {{ $name_of_employee }}</span>
                    <span>Date: {{ $date }}</span>
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

                </thead>

                <tbody>
                    <!-- Main header row with column titles -->
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
                        <th colspan="4">RATING</th>
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

                    <!-- Subheader row for Rating columns when column 8 is selected -->
                    @if(in_array(8, $selectedColumns))
                    <tr>
                        @php
                        $visibleColsBeforeRating = 2 + // PPA and Performance Indicators (always shown)
                        (in_array(3, $selectedColumns) ? 1 : 0) +
                        (in_array(4, $selectedColumns) ? 1 : 0) +
                        (in_array(5, $selectedColumns) ? 1 : 0) +
                        (in_array(6, $selectedColumns) ? 1 : 0) +
                        (in_array(7, $selectedColumns) ? 1 : 0);

                        $visibleColsAfterRating =
                        (in_array(9, $selectedColumns) ? 1 : 0) +
                        (in_array(10, $selectedColumns) ? 1 : 0) +
                        (in_array(11, $selectedColumns) ? 1 : 0);
                        @endphp

                        <th colspan="{{ $visibleColsBeforeRating }}"></th>
                        <th>Q</th>
                        <th>T</th>
                        <th>E</th>
                        <th>AVE</th>
                        @if($visibleColsAfterRating > 0)
                        <th colspan="{{ $visibleColsAfterRating }}"></th>
                        @endif
                    </tr>
                    @endif
                    <!-- Section: CORE FUNCTIONS -->
                    @php
                    // Calculate total visible columns for section headers
                    $totalVisibleCols = 2 + // PPA and Performance Indicators (always shown)
                    (in_array(3, $selectedColumns) ? 1 : 0) +
                    (in_array(4, $selectedColumns) ? 1 : 0) +
                    (in_array(5, $selectedColumns) ? 1 : 0) +
                    (in_array(6, $selectedColumns) ? 1 : 0) +
                    (in_array(7, $selectedColumns) ? 1 : 0) +
                    (in_array(8, $selectedColumns) ? 4 : 0) + // Rating has 4 columns (Q,T,E,AVE)
                    (in_array(9, $selectedColumns) ? 1 : 0) +
                    (in_array(10, $selectedColumns) ? 1 : 0) +
                    (in_array(11, $selectedColumns) ? 1 : 0);
                    @endphp

                    <tr class="section-header">
                        <th colspan="{{ $totalVisibleCols }}">CORE FUNCTIONS RESEARCH AND EXTENSION</th>
                    </tr>
                    <tr class="section-header">
                        <th colspan="{{ $totalVisibleCols }}">
                            Development Goal 1: Challenge Innovation by
                            Expanding Academic and Research Programs
                        </th>
                    </tr>
                    <tr class="section-header">
                        <th colspan="{{ $totalVisibleCols }}">
                            Objective 2. (Research). Objective 2. (Research) To
                            Enhance Research Productivity Contributing To
                            Sustainable Development
                        </th>
                    </tr>

                    <!-- Core Functions Targets -->
                    @if(isset($targets['core']) && count($targets['core']) > 0)
                    @foreach($targets['core'] as $target)
                    @php $firstSubTarget = true; @endphp
                    @foreach($target['sub_targets'] as $sub_target)
                    <tr>
                        @if($firstSubTarget)
                        <td rowspan="{{ count($target['sub_targets']) }}">
                            {{ $target['description'] }}
                        </td>
                        @php $firstSubTarget = false; @endphp
                        @endif
                        <td>{{ $sub_target['description'] }}</td>

                        <!-- Display standard columns based on selection -->
                        @if(in_array(3, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][3] ?? '' }}</td>
                        @endif

                        @if(in_array(4, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][4] ?? '' }}</td>
                        @endif

                        @if(in_array(5, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][5] ?? '' }}</td>
                        @endif

                        @if(in_array(6, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][6] ?? '' }}</td>
                        @endif

                        @if(in_array(7, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][7] ?? '' }}</td>
                        @endif

                        <!-- Display rating columns if selected -->
                        @if(in_array(8, $selectedColumns))
                        <td>{{ $sub_target['user_tasks']['q'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks']['t'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks']['e'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks'][8] ?? '' }}</td>
                        @endif

                        @if(in_array(9, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][9] ?? '' }}</td>
                        @endif

                        @if(in_array(10, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][10] ?? '' }}</td>
                        @endif

                        @if(in_array(11, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][11] ?? '' }}</td>
                        @endif
                    </tr>
                    @endforeach
                    @endforeach
                    @endif

                    <!-- Subrating row for Core Functions -->
                    @if(in_array(8, $selectedColumns))
                    <tr class="subrating-row">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">SUBRATING: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>
                    @endif

                    <!-- Section: STRATEGIC FUNCTIONS ('strategic'%) -->
                    <tr class="section-header">
                        <th colspan="{{ $totalVisibleCols }}">STRATEGIC</th>
                    </tr>

                    <!-- Strategic Functions Targets ('strategic'%) -->
                    @if(isset($targets['strategic']) && count($targets['strategic']) > 0)
                    @foreach($targets['strategic'] as $target)
                    @php $firstSubTarget = true; @endphp
                    @foreach($target['sub_targets'] as $sub_target)
                    <tr>
                        @if($firstSubTarget)
                        <td rowspan="{{ count($target['sub_targets']) }}">
                            {{ $target['description'] }}
                        </td>
                        @php $firstSubTarget = false; @endphp
                        @endif
                        <td>{{ $sub_target['description'] }}</td>

                        <!-- Display standard columns based on selection -->
                        @if(in_array(3, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][3] ?? '' }}</td>
                        @endif

                        @if(in_array(4, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][4] ?? '' }}</td>
                        @endif

                        @if(in_array(5, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][5] ?? '' }}</td>
                        @endif

                        @if(in_array(6, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][6] ?? '' }}</td>
                        @endif

                        @if(in_array(7, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][7] ?? '' }}</td>
                        @endif

                        <!-- Display rating columns if selected -->
                        @if(in_array(8, $selectedColumns))
                        <td>{{ $sub_target['user_tasks']['q'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks']['t'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks']['e'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks'][8] ?? '' }}</td>
                        @endif

                        @if(in_array(9, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][9] ?? '' }}</td>
                        @endif

                        @if(in_array(10, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][10] ?? '' }}</td>
                        @endif

                        @if(in_array(11, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][11] ?? '' }}</td>
                        @endif
                    </tr>
                    @endforeach
                    @endforeach
                    @endif

                    <!-- Subrating row for Strategic Functions ('strategic'%) -->
                    @if(in_array(8, $selectedColumns))
                    <tr class="subrating-row">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">SUBRATING: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>
                    @endif

                    <!-- Section: STRATEGIC FUNCTIONS (10%) -->
                    <tr class="section-header">
                        <th colspan="{{ $totalVisibleCols }}">SUPPORT</th>
                    </tr>

                    <!-- Strategic Functions Targets (10%) -->
                    @if(isset($targets['support']) && count($targets['support']) > 0)
                    @foreach($targets['support'] as $target)
                    @php $firstSubTarget = true; @endphp
                    @foreach($target['sub_targets'] as $sub_target)
                    <tr>
                        @if($firstSubTarget)
                        <td rowspan="{{ count($target['sub_targets']) }}">
                            {{ $target['description'] }}
                        </td>
                        @php $firstSubTarget = false; @endphp
                        @endif
                        <td>{{ $sub_target['description'] }}</td>

                        <!-- Display standard columns based on selection -->
                        @if(in_array(3, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][3] ?? '' }}</td>
                        @endif

                        @if(in_array(4, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][4] ?? '' }}</td>
                        @endif

                        @if(in_array(5, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][5] ?? '' }}</td>
                        @endif

                        @if(in_array(6, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][6] ?? '' }}</td>
                        @endif

                        @if(in_array(7, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][7] ?? '' }}</td>
                        @endif

                        <!-- Display rating columns if selected -->
                        @if(in_array(8, $selectedColumns))
                        <td>{{ $sub_target['user_tasks']['q'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks']['t'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks']['e'] ?? '' }}</td>
                        <td>{{ $sub_target['user_tasks'][8] ?? '' }}</td>
                        @endif

                        @if(in_array(9, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][9] ?? '' }}</td>
                        @endif

                        @if(in_array(10, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][10] ?? '' }}</td>
                        @endif

                        @if(in_array(11, $selectedColumns))
                        <td>{{ $sub_target['user_tasks'][11] ?? '' }}</td>
                        @endif
                    </tr>
                    @endforeach
                    @endforeach
                    @endif

                    <!-- Subrating row for Strategic Functions (10%) -->
                    @if(in_array(8, $selectedColumns))
                    <tr class="subrating-row">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">SUBRATING: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>

                    <!-- Final Rating rows -->
                    <tr class="final-ratings">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">Core: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>

                    <tr class="final-ratings">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">Strategic: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>

                    <tr class="final-ratings">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">Support: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>

                    <tr class="final-ratings">
                        <td colspan="{{ $visibleColsBeforeRating }}"></td>
                        <td colspan="4">Final Ave: </td>
                        @if($visibleColsAfterRating > 0)
                        <td colspan="{{ $visibleColsAfterRating }}"></td>
                        @endif
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Signature section footer -->
        <table class="footer-table">
            <tr>
                <td>
                    <span>Name and Signature of Ratee: {{ $ratee_name }}</span>
                    <span>Position: {{ $ratee_position }}</span>
                    <span>Date: {{ $date }}</span>
                </td>
                <td>
                    <span>Final Rating by: {{ $final_rating_by_name }}</span>
                    <span>Position: {{ $final_rating_by_position }}</span>
                    <span>Date: {{ $date }}</span>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>