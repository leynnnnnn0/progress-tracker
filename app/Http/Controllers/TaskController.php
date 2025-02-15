<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Target;
use App\Models\UsersOffices;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $offices = Office::getOptions();
        $office = request('office') ?? $offices->first()['value'];

        $query = Target::query()->with(['sub_targets.user_tasks']);

        $usersOfficesId = UsersOffices::where('user_id', Auth::id())->where('office_id', $office)->first()->id;

        $query->whereHas('user_tasks', function (Builder $query) use ($usersOfficesId) {
            $query->where('users_offices_id', $usersOfficesId);
        });

        $targets = $query->get()->map(function ($item) {
            $sub_targets = $item->sub_targets->map(function ($item) {
                $user_task = $item->user_tasks->first();
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
            'offices' => $offices,
            'filters' => request()->only(['office'])
        ]);
    }
}
