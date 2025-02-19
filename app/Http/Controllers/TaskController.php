<?php

namespace App\Http\Controllers;

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
        $users = User::getOptions();

        $query = Target::query()->with(['sub_targets.user_tasks']);

        $user = request('user') ?? $users->count()  > 0 ? $users->first()['value'] : null;
        $offices = Office::getOptions($user);
        $office = request('office') ?? $offices->first()['value'];

        $query->whereHas('sub_targets.user_tasks', function (Builder $query) use ($office) {
            $query->where('office_id', $office);
        });

        $targets = $query->get()->map(function ($item) {
            $sub_targets = $item->sub_targets->map(function ($item) {
                $user_task = $item->user_tasks->first();

                if (!$user_task) return [];

                return [
                    'sub_target_id' => $item->id,
                    'description' => $item->description,
                    'user_task_id' => $user_task->id,
                    'user_tasks' => [
                        'target_number' => $user_task->target_number,
                        "success_indicator" => $user_task->success_indicator,
                        "individual_accountable" => $user_task->individual_accountable,
                        "actual_accomplishments" => $user_task->actual_accomplishments,
                        "actual_accomplishments_number" => $user_task->actual_accomplishments_number,
                        "q" => $user_task->q,
                        "t" => $user_task->t,
                        "e" => $user_task->e,
                        'ave' => 0,
                        "remark" => $user_task->remarks,
                        "link_to_evidence" => $user_task->link_to_evidence,
                        "pmt_remark" => $user_task->pmt_remark
                    ],
                ];
            });
            return [
                'target_id' => $item->id,
                'description' => $item->description,
                'percentage_group' => $item->percentage_group,
                'sub_targets' => $sub_targets
            ];
        })
            ->groupBy('percentage_group');



        return Inertia::render('Task/Index', [
            'targets' => $targets,
            'offices' => $offices ?? [],
            'filters' => request()->only(['office', 'user']),
            'users' => $users
        ]);
    }
}
