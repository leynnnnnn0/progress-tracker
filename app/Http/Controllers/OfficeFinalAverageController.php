<?php

namespace App\Http\Controllers;

use App\Exports\OfficeFinalAverageExport;
use App\Models\Office;
use App\Models\SubTarget;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class OfficeFinalAverageController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = Office::with(['user_tasks.sub_target.target', 'group_percentage']);

        if ($search) {
            $query->whereAny(['name', 'office_code'], 'like', "%$search%");
        }

        $offices = $query->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(function ($office) {
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



        return Inertia::render('OfficeFinalAverage/Index', [
            'offices' => $offices,
            'filters' => request()->only(['search'])
        ]);
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

    public function downloadExcel()
    {
        return Excel::download(new OfficeFinalAverageExport(), 'offices-target-final-average-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadPDF()
    {
        $search = request('search');
        $query = Office::with(['user_tasks.sub_target.target', 'group_percentage']);

        if ($search) {
            $query->whereAny(['name', 'office_code'], 'like', "%$search%");
        }

        $offices = $query->latest()
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

        $pdf = Pdf::loadView('pdf.offices-final-average-report', [
            'offices' => $offices,
        ]);

        return $pdf->setPaper('legal', 'landscape')->download('offices-final-average-report.pdf');
    }
}
