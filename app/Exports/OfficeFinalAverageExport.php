<?php

namespace App\Exports;

use App\Models\Office;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OfficeFinalAverageExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Office::with(['user_tasks.sub_target.target', 'group_percentage']);

        return $query->latest()
            ->get()
            ->map(function ($office) {
                $userTasks = $office->user_tasks
                    ->filter(function ($item) {
                        return $item->target_number > 0;
                    })
                    ->groupBy(function ($item) {
                        return $item->sub_target->target->group;
                    });
                $groupPercentage = $office->group_percentage;
                $corePercentage = $groupPercentage?->core ?? 0;
                $strategicPercentage = $groupPercentage?->strategic ?? 0;
                $supportPercentage = $groupPercentage?->support ?? 0;


                $coreSubrating = isset($userTasks['core']) ? $this->getGroupAverage($userTasks['core']) : 0;

                $strategicSubrating = isset($userTasks['strategic']) ? $this->getGroupAverage($userTasks['strategic']) : 0;

                $supportSubrating = isset($userTasks['support']) ? $this->getGroupAverage($userTasks['support']) : 0;

                $core = $corePercentage ? ($corePercentage / 100) * $coreSubrating : 0;
                $strategic = $strategicPercentage ? ($strategicPercentage / 100) * $strategicSubrating : 0;
                $support = $supportPercentage ? ($supportPercentage / 100) * $supportSubrating : 0;

                $final_average = $core + $strategic + $support;

                return [
                    'id' => $office->id,
                    'name' => $office->name,
                    'office_code' => $office->office_code,
                    'user_tasks' => $userTasks,
                    'final_average' => number_format($final_average, '2')
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Office',
            'Office Code',
            'Final Average',
        ];
    }

    public function map($row): array
    {
        return [
            $row['id'],
            $row['name'],
            $row['office_code'],
            $row['final_average'],
        ];
    }

    public function getGroupAverage($userTasks)
    {
        $coreSubrating = 0;
        if ($userTasks) {
            $notNullColumns = 0;
            foreach ($userTasks as $task) {
                $columnsCount = 0;
                $sum = 0;
                if ($task->q) {
                    $columnsCount++;
                    $sum += $task->q;
                }
                if ($task->t) {
                    $columnsCount++;
                    $sum += $task->t;
                }
                if ($task->e) {
                    $columnsCount++;
                    $sum += $task->e;
                }
                if ($columnsCount > 0) {
                    $notNullColumns++;
                    $coreSubrating += $sum / $columnsCount;
                }
            }

            return $notNullColumns ?  $coreSubrating / $notNullColumns : 0;
        }

        return 0;
    }
}
