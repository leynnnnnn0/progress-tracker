<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Group;
use App\Models\Office;
use App\Models\Target;
use App\Models\User;
use App\Exports\TaskReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TaskReportController extends Controller
{
    public function index()
    {
        return view('pdf.task-report');
    }

    /**
     * Process targets data from the database
     * 
     * @param int $office
     * @return \Illuminate\Support\Collection
     */
    private function processTargetsData($office)
    {
        $query = Target::query()->with(['sub_targets.user_tasks', 'sub_targets.objective', 'offices']);

        $query->whereHas('sub_targets.user_tasks', function (Builder $query) use ($office) {
            $query->where('office_id', $office);
        });

        $query->whereHas('offices', function ($query) use ($office) {
            $query->where('office_id', $office);
        });

        $query->with(['sub_targets.user_tasks' => function ($query) use ($office) {
            $query->where('office_id', $office);
        }]);

        return $query->get()->map(function ($item) {
            $sub_targets = $item->sub_targets->map(function ($item) {
                $user_task = $item->user_tasks->first();

                if (!$user_task || $user_task->target_number == false) return [];

                $count = 0;
                if ($user_task->q > 0) $count++;
                if ($user_task->t > 0) $count++;
                if ($user_task->e > 0) $count++;

                $average = $count > 0 ? number_format(($user_task->q + $user_task->t + $user_task->e) / $count, 2) : null;

                return [
                    'sub_target_id' => $item->id,
                    'description' => $item->description,
                    'user_task_id' => $user_task->id,
                    'user_tasks' => [
                        3 => $user_task->target_number,
                        4 => $user_task->success_indicator,
                        5 => $user_task->individual_accountable,
                        6 => $user_task->actual_accomplishments_number,
                        7 => $user_task->actual_accomplishments,
                        "q" => $user_task->q,
                        "t" => $user_task->t,
                        "e" => $user_task->e,
                        8 => $average,
                        9 => $user_task->remark,
                        10 => $user_task->link_to_evidence,
                        11 => $user_task->pmt_remark
                    ],
                ];
            })->filter()->values();

            $subrating = 0;

            foreach ($sub_targets as $subTarget) {
                if (!isset($subTarget['user_tasks'][8])) continue;
                $subrating += floatval($subTarget['user_tasks'][8]);
            }

            return [
                'target_id' => $item->id,
                'description' => $item->description,
                'group' => $item->group,
                'sub_targets' => $sub_targets,
                'subrating' => $subrating
            ];
        })->groupBy('group');
    }

    /**
     * Calculate ratings for core, strategic, and support targets
     * 
     * @param \Illuminate\Support\Collection $targets
     * @param Group $group
     * @return array
     */
    private function calculateRatings($targets, $group)
    {
        $calculateAverage = function ($collection) {
            $filtered = $collection->where('subrating', '>', 0);
            $count = $filtered->count();
            return $count > 0 ? number_format($filtered->sum('subrating') / ($count + 1), 2) : 0;
        };

        $coreSubrating = isset($targets['core']) ? $calculateAverage(collect($targets['core'])) : 0;
        $strategicSubrating = isset($targets['strategic']) ? $calculateAverage(collect($targets['strategic'])) : 0;
        $supportSubrating = isset($targets['support']) ? $calculateAverage(collect($targets['support'])) : 0;

        $coreOnPercentage = isset($group['core']) ? number_format($coreSubrating * ($group['core'] / 100), 2) : 0;
        $strategicOnPercentage = isset($group['strategic']) ? number_format($strategicSubrating * ($group['strategic'] / 100), 2) : 0;
        $supportOnPercentage = isset($group['support']) ? number_format($supportSubrating * ($group['support'] / 100), 2) : 0;

        $finalAverage = number_format(($coreOnPercentage + $strategicOnPercentage + $supportOnPercentage), 2);

        return [
            'coreSubrating' => $coreSubrating,
            'strategicSubrating' => $strategicSubrating,
            'supportSubrating' => $supportSubrating,
            'coreOnPercent' => $coreOnPercentage,
            'strategicOnPercent' => $strategicOnPercentage,
            'supportOnPercent' => $supportOnPercentage,
            'finalAverage' => $finalAverage
        ];
    }

    /**
     * Get employee data for selected IDs
     * 
     * @param Request $request
     * @return array
     */
    private function getEmployeeData(Request $request)
    {
        $employees = Employee::whereIn('id', [
            $request->input('approved_by'),
            $request->input('ratee'),
            $request->input('final_rating_by'),
            $request->input('name_of_employee')
        ])->get();

        $approved_by = $employees->where('id', $request->input('approved_by'))->first();
        $ratee = $employees->where('id', $request->input('ratee'))->first();
        $final_rating_by = $employees->where('id', $request->input('final_rating_by'))->first();
        $name_of_employee = $employees->where('id', $request->input('name_of_employee'))->first();

        return [
            'approved_by_name' => $approved_by->full_name ?? 'N/A',
            'approved_by_position' => $approved_by->position ?? 'N/A',
            'ratee_name' => $ratee->full_name ?? 'N/A',
            'ratee_position' => $ratee->position ?? 'N/A',
            'final_rating_by_name' => $final_rating_by->full_name ?? 'N/A',
            'final_rating_by_position' => $final_rating_by->position ?? 'N/A',
            'name_of_employee' => $name_of_employee->full_name ?? 'N/A'
        ];
    }

    public function download(Request $request)
    {
        $validated = $request->validate([
            'selectedColumns' => ['required']
        ]);

        $users = User::getOptions();
        $userId = $users->count() > 0 ? $users->first()['value'] : null;
        $user = request('user') ?? $userId;

        $offices = Office::getOptions($user);
        $office = request('office') ?? $offices->first()['value'];

        $goals = Goal::with('objectives')->get();
        $targets = $this->processTargetsData($office);
        $group = Group::where('office_id', $office)->first();
        $ratings = $this->calculateRatings($targets, $group);
        $employeeData = $this->getEmployeeData($request);

        $data = [
            'selectedColumns' => $validated['selectedColumns'],
            'targets' => $targets,
            'full_name' => User::find(request('full_name'))?->full_name ?? 'N/a',
            'office_name' => Office::find(request('office'))?->name ?? 'N/a',
            'date_range' => request('date_range') == 0 ? 'January - June ' . date('Y') : 'July - December ' . date('Y'),
            'date' => now()->format('F d, Y'),
            'group' => $group,
            'goals' => $goals
        ];

        $pdf = Pdf::loadView('pdf.task-report', array_merge($data, $ratings, $employeeData));
        $pdf->setOption('repeatTableHeader', false);

        return $pdf->setPaper('legal', 'landscape')->download('task-report.pdf');
    }

    public function exportExcel(Request $request)
    {
        $validated = $request->validate([
            'selectedColumns' => ['required']
        ]);

        $users = User::getOptions();
        $userId = $users->count() > 0 ? $users->first()['value'] : null;
        $user = request('user') ?? $userId;

        $offices = Office::getOptions($user);
        $office = request('office') ?? $offices->first()['value'];

        $targets = $this->processTargetsData($office);
        $group = Group::where('office_id', $office)->first();
        $ratings = $this->calculateRatings($targets, $group);

        $data = [
            'targets' => $targets,
            'selectedColumns' => $validated['selectedColumns']
        ];

        return Excel::download(new TaskReportExport(array_merge($data, $ratings)), 'task-report.xlsx');
    }
}
