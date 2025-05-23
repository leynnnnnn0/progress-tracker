<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Group;
use App\Models\Objective;
use App\Models\Office;
use App\Models\Target;
use App\Models\User;
use App\Models\UsersOffices;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $employees = Employee::getOptions();
        $users = User::getOptions();

        $query = Target::query()->with(['sub_targets.user_tasks', 'sub_targets.objective', 'offices']);
        $userId = $users->count() > 0 ? $users->first()['value'] : null;

        $goals = Goal::with('objectives')->get();

        $objectives = Objective::all();

        $user = request('user') ?? $userId;

        $offices = Office::getOptions($user);
        $office = request('office') ?? $offices->first()['value'];

        $group = Group::where('office_id', $office)->first();

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
                    'objective_id' => $item->objective?->id ?? null,
                    'sub_target_id' => $item->id,
                    'description' => $item->description,
                    'user_task_id' => $user_task->id,
                    'user_tasks' => [
                        'target_number' => $user_task->target_number,
                        "success_indicator" => $user_task->success_indicator,
                        "individual_accountable" => $user_task->individual_accountable,

                        "actual_accomplishments_number" => $user_task->actual_accomplishments_number,
                        "actual_accomplishments" => $user_task->actual_accomplishments,
                        "q" => $user_task->q,
                        "t" => $user_task->t,
                        "e" => $user_task->e,
                        'ave' => $count > 0 ? number_format(($user_task->q + $user_task->t + $user_task->e) / $count, 2) : null,
                        "remark" => $user_task->remark,
                        "link_to_evidence" => $user_task->link_to_evidence,
                        "pmt_remark" => $user_task->pmt_remark,
                    ],
                ];
            })->filter()->values();


            $subrating = 0;

            foreach ($sub_targets as $subTarget) {
                if (!isset($subTarget['user_tasks']['ave'])) continue;
                $subrating += floatval($subTarget['user_tasks']['ave']);
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


        return Inertia::render('Task/Index', [
            'targets' => $targets,
            'offices' => $offices ?? [],
            'filters' => request()->only(['office', 'user']),
            'users' => $users,
            'group' => $group,
            'employees' => $employees,
            'goals' => $goals,
            'objectives' => $objectives
        ]);
    }
}
