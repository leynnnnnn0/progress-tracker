<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Group;
use App\Models\Office;
use App\Models\Target;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskReportController extends Controller
{
    public function index()
    {
        return view('pdf.task-report');
    }

    public function download(Request $request)
    {
        $users = User::getOptions();

        $query = Target::query()->with(['sub_targets.user_tasks', 'offices']);
        $userId = $users->count() > 0 ? $users->first()['value'] : null;
        $user = request('user') ?? $userId;

        $offices = Office::getOptions($user);
        $office = request('office') ?? $offices->first()['value'];

        $query->whereHas('sub_targets.user_tasks', function (Builder $query) use ($office) {
            $query->where('office_id', $office);
        });

        $query->whereHas('offices', function ($query) use ($office) {
            $query->where('office_id', $office);
        });


        $query->with(['sub_targets.user_tasks' => function ($query) use ($office) {
            $query->where('office_id', $office);
        }]);


        $targets = $query->get()->map(function ($item) {
            $sub_targets = $item->sub_targets->map(function ($item) {
                $user_task = $item->user_tasks->first();

                if (!$user_task || $user_task->target_number == false) return [];
                $count = 0;
                if ($user_task->q > 0) $count++;
                if ($user_task->t > 0) $count++;
                if ($user_task->e > 0) $count++;

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
                        8 => $count > 0 ? number_format(($user_task->q + $user_task->t + $user_task->e) / $count, 2) : null,
                        9 => $user_task->remark,
                        10 => $user_task->link_to_evidence,
                        11 => $user_task->pmt_remark
                    ],
                ];
            })->filter();

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
        })
            ->groupBy('group');


        $validated = $request->validate([
            'selectedColumns' => ['required']
        ]);

        $employees = Employee::whereIn('id', [
            request('approved_by'),
            request('ratee'),
            request('final_rating_by'),
            request('name_of_employee')
        ])->get();




        $approved_by = $employees->where('id', request('approved_by'))->first();

        $approved_by_name = $approved_by->full_name;
        $approved_by_position = $approved_by->position;

        $ratee = $employees->where('id', request('ratee'))->first();
        $ratee_name = $ratee->full_name;
        $ratee_position = $ratee->position;

        $final_rating_by = $employees->where('id', request('final_rating_by'))->first();
        $final_rating_by_name = $final_rating_by->full_name;
        $final_rating_by_position = $final_rating_by->position;

        $date = now()->format('F d, Y');

        $coreSubrating = number_format(isset($targets['core']) ? collect($targets['core'])->sum('subrating') / (collect($targets['core'])->where('subrating', '>', 0)->count()) : 0, '2');
        $strategicSubrating = number_format(isset($targets['strategic']) ? collect($targets['strategic'])->sum('subrating') / (collect($targets['strategic'])->where('subrating', '>', 0)->count()) : 0, 2);
        $supportSubrating = number_format(isset($targets['support']) ? collect($targets['support'])->sum('subrating') / (collect($targets['support'])->where('subrating', '>', 0)->count()) : 0, 2);

        $group = Group::where('office_id', $office)->first();

        $coreOnPercentage = number_format(isset($group['core']) ? $coreSubrating * ($group['core'] / 100) : 0, 2);
        $strategicOnPercentage = number_format(isset($group['strategic']) ? $strategicSubrating * ($group['strategic'] / 100) : 0, 2);
        $supportOnPercentage = number_format(isset($group['support']) ? $supportSubrating * ($group['support'] / 100) : 0, 2);



        $pdf = Pdf::loadView('pdf.task-report', [
            'selectedColumns' => $validated['selectedColumns'],
            'targets' => $targets,
            'full_name' => User::find(request('full_name'))?->full_name ?? 'N/a',
            'office_name' => Office::find(request('office'))?->name ?? 'N/a',
            'name_of_employee' =>  $employees->where('id', request('name_of_employee'))->first()->full_name,
            'approved_by_name' => $approved_by_name,
            'approved_by_position' => $approved_by_position,
            'ratee_name' => $ratee_name,
            'ratee_position' => $ratee_position,
            'final_rating_by_name' => $final_rating_by_name,
            'final_rating_by_position' => $final_rating_by_position,
            'date_range' => request('date_range') == 0 ? 'January - June ' . date('Y') : 'July - December ' . date('Y'),
            'date' => $date,
            'group' => $group,
            'coreSubrating' => $coreSubrating,
            'strategicSubrating' => $strategicSubrating,
            'supportSubrating' => $supportSubrating,
            'finalAverage' => number_format(($coreOnPercentage + $strategicOnPercentage +
                $supportOnPercentage), 2),
            'coreOnPercent' => $coreOnPercentage,
            'strategicOnPercent' => $strategicOnPercentage,
            'supportOnPercent' => $supportOnPercentage
        ]);
        $pdf->setOption('repeatTableHeader', false);

        return $pdf->setPaper('legal', 'landscape')->download('task-report.pdf');
    }
}
