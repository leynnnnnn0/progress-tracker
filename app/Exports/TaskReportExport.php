<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TaskReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, ShouldAutoSize, WithColumnWidths, WithEvents
{
    protected $targets;
    protected $selectedColumns;
    protected $coreSubrating;
    protected $strategicSubrating;
    protected $supportSubrating;
    protected $coreOnPercent;
    protected $strategicOnPercent;
    protected $supportOnPercent;
    protected $finalAverage;

    public function __construct($data)
    {
        $this->targets = $data['targets'];
        $this->selectedColumns = $data['selectedColumns'];
        $this->coreSubrating = $data['coreSubrating'];
        $this->strategicSubrating = $data['strategicSubrating'];
        $this->supportSubrating = $data['supportSubrating'];
        $this->coreOnPercent = $data['coreOnPercent'];
        $this->strategicOnPercent = $data['strategicOnPercent'];
        $this->supportOnPercent = $data['supportOnPercent'];
        $this->finalAverage = $data['finalAverage'];
    }

    public function collection()
    {
        $rows = new Collection();
        $sections = ['core', 'strategic', 'support'];

        // Add section headers and data
        foreach ($sections as $section) {
            // Add section header
            $rows->push(['section_header' => strtoupper($section)]);

            if (isset($this->targets[$section]) && count($this->targets[$section]) > 0) {
                foreach ($this->targets[$section] as $target) {
                    $firstSubTarget = true;

                    foreach ($target['sub_targets'] as $sub_target) {
                        $row = [];
                        $row['target'] = $firstSubTarget ? $target['description'] : '';
                        $row['sub_target'] = $sub_target['description'];

                        // Add selected columns
                        if (in_array(3, $this->selectedColumns)) {
                            $row['target_number'] = $sub_target['user_tasks'][3] ?? '';
                        }
                        if (in_array(4, $this->selectedColumns)) {
                            $row['success_indicator'] = $sub_target['user_tasks'][4] ?? '';
                        }
                        if (in_array(5, $this->selectedColumns)) {
                            $row['individual_accountable'] = $sub_target['user_tasks'][5] ?? '';
                        }
                        if (in_array(6, $this->selectedColumns)) {
                            $row['actual_accomplishments_number'] = $sub_target['user_tasks'][6] ?? '';
                        }
                        if (in_array(7, $this->selectedColumns)) {
                            $row['actual_accomplishments'] = $sub_target['user_tasks'][7] ?? '';
                        }
                        if (in_array(8, $this->selectedColumns)) {
                            $row['q'] = $sub_target['user_tasks']['q'] ?? '';
                            $row['t'] = $sub_target['user_tasks']['t'] ?? '';
                            $row['e'] = $sub_target['user_tasks']['e'] ?? '';
                            $row['ave'] = $sub_target['user_tasks'][8] ?? '';
                        }
                        if (in_array(9, $this->selectedColumns)) {
                            $row['remark'] = $sub_target['user_tasks'][9] ?? '';
                        }
                        if (in_array(10, $this->selectedColumns)) {
                            $row['link_to_evidence'] = $sub_target['user_tasks'][10] ?? '';
                        }
                        if (in_array(11, $this->selectedColumns)) {
                            $row['pmt_remark'] = $sub_target['user_tasks'][11] ?? '';
                        }

                        $rows->push($row);
                        $firstSubTarget = false;
                    }
                }
            }

            // Add subrating for each section
            if (in_array(8, $this->selectedColumns)) {
                $subrating = '';
                $sectionOnPercent = '';

                if ($section === 'core') {
                    $subrating = $this->coreSubrating;
                    $sectionOnPercent = $this->coreOnPercent;
                } elseif ($section === 'strategic') {
                    $subrating = $this->strategicSubrating;
                    $sectionOnPercent = $this->strategicOnPercent;
                } elseif ($section === 'support') {
                    $subrating = $this->supportSubrating;
                    $sectionOnPercent = $this->supportOnPercent;
                }

                // Add subrating row
                $subratingRow = [
                    'target' => '',
                    'sub_target' => 'SUBRATING: ' . $subrating
                ];

                // Fill with empty values for other columns
                foreach ($this->selectedColumns as $col) {
                    if ($col < 8) {
                        $subratingRow[$this->getColumnName($col)] = '';
                    }
                }

                // Add percentage row
                $percentRow = [
                    'target' => '',
                    'sub_target' => strtoupper($section) . ': ' . $sectionOnPercent
                ];

                // Fill with empty values for other columns
                foreach ($this->selectedColumns as $col) {
                    if ($col < 8) {
                        $percentRow[$this->getColumnName($col)] = '';
                    }
                }

                $rows->push($subratingRow);
                $rows->push($percentRow);
            }
        }

        // Add final average row
        if (in_array(8, $this->selectedColumns)) {
            $finalRow = [
                'target' => '',
                'sub_target' => 'FINAL AVERAGE: ' . $this->finalAverage
            ];

            // Fill with empty values for other columns
            foreach ($this->selectedColumns as $col) {
                if ($col < 8) {
                    $finalRow[$this->getColumnName($col)] = '';
                }
            }

            $rows->push($finalRow);
        }

        return $rows;
    }

    private function getColumnName($column)
    {
        switch ($column) {
            case 3:
                return 'target_number';
            case 4:
                return 'success_indicator';
            case 5:
                return 'individual_accountable';
            case 6:
                return 'actual_accomplishments_number';
            case 7:
                return 'actual_accomplishments';
            case 9:
                return 'remark';
            case 10:
                return 'link_to_evidence';
            case 11:
                return 'pmt_remark';
            default:
                return '';
        }
    }

    public function headings(): array
    {
        $headings = ['PROGRAMS, PROJECTS, ACTIVITIES', 'PERFORMANCE INDICATORS'];

        if (in_array(3, $this->selectedColumns)) {
            $headings[] = 'TARGET NUMBER';
        }
        if (in_array(4, $this->selectedColumns)) {
            $headings[] = 'SUCCESS INDICATORS';
        }
        if (in_array(5, $this->selectedColumns)) {
            $headings[] = 'INDIVIDUAL ACCOUNTABLE';
        }
        if (in_array(6, $this->selectedColumns)) {
            $headings[] = 'ACTUAL ACCOMPLISHMENTS NUMBER';
        }
        if (in_array(7, $this->selectedColumns)) {
            $headings[] = 'ACTUAL ACCOMPLISHMENTS';
        }
        if (in_array(8, $this->selectedColumns)) {
            $headings[] = 'Q';
            $headings[] = 'T';
            $headings[] = 'E';
            $headings[] = 'AVE';
        }
        if (in_array(9, $this->selectedColumns)) {
            $headings[] = 'REMARK';
        }
        if (in_array(10, $this->selectedColumns)) {
            $headings[] = 'LINK TO EVIDENCE';
        }
        if (in_array(11, $this->selectedColumns)) {
            $headings[] = 'PMT REMARK';
        }

        return $headings;
    }

    public function map($row): array
    {
        // If it's a section header row
        if (isset($row['section_header'])) {
            $mapped = [$row['section_header']];

            // Fill with empty values for other columns
            $columnCount = count($this->headings()) - 1;
            for ($i = 0; $i < $columnCount; $i++) {
                $mapped[] = '';
            }

            return $mapped;
        }

        // For normal data rows
        $mapped = [
            $row['target'],
            $row['sub_target']
        ];

        if (in_array(3, $this->selectedColumns)) {
            $mapped[] = $row['target_number'] ?? '';
        }
        if (in_array(4, $this->selectedColumns)) {
            $mapped[] = $row['success_indicator'] ?? '';
        }
        if (in_array(5, $this->selectedColumns)) {
            $mapped[] = $row['individual_accountable'] ?? '';
        }
        if (in_array(6, $this->selectedColumns)) {
            $mapped[] = $row['actual_accomplishments_number'] ?? '';
        }
        if (in_array(7, $this->selectedColumns)) {
            $mapped[] = $row['actual_accomplishments'] ?? '';
        }
        if (in_array(8, $this->selectedColumns)) {
            $mapped[] = $row['q'] ?? '';
            $mapped[] = $row['t'] ?? '';
            $mapped[] = $row['e'] ?? '';
            $mapped[] = $row['ave'] ?? '';
        }
        if (in_array(9, $this->selectedColumns)) {
            $mapped[] = $row['remark'] ?? '';
        }
        if (in_array(10, $this->selectedColumns)) {
            $mapped[] = $row['link_to_evidence'] ?? '';
        }
        if (in_array(11, $this->selectedColumns)) {
            $mapped[] = $row['pmt_remark'] ?? '';
        }

        return $mapped;
    }

    public function title(): string
    {
        return 'Task Report';
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // Style for headings
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'F9FAFB',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        // Style for all cells
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        // Find and style section headers
        for ($i = 1; $i <= $lastRow; $i++) {
            $cellValue = $sheet->getCell('A' . $i)->getValue();
            if ($cellValue === 'CORE' || $cellValue === 'STRATEGIC' || $cellValue === 'SUPPORT') {
                $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'F3F4F6',
                        ],
                    ],
                ]);
            }

            // Check for subrating and final average rows
            if (
                strpos($sheet->getCell('B' . $i)->getValue(), 'SUBRATING') !== false ||
                strpos($sheet->getCell('B' . $i)->getValue(), 'CORE') !== false ||
                strpos($sheet->getCell('B' . $i)->getValue(), 'STRATEGIC') !== false ||
                strpos($sheet->getCell('B' . $i)->getValue(), 'SUPPORT') !== false ||
                strpos($sheet->getCell('B' . $i)->getValue(), 'FINAL AVERAGE') !== false
            ) {
                $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'F9FAFB',
                        ],
                    ],
                ]);
            }
        }

        return [
            // Set default row height
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 40,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getDelegate()->getStyle('A1:' . $event->sheet->getHighestColumn() . '1')
                    ->getAlignment()->setWrapText(true)->setVertical('center')->setHorizontal('center');
            },
        ];
    }
}
