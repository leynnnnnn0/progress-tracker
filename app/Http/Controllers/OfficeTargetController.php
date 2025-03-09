<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Target;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeTargetController extends Controller
{
    public function index()
    {
        $offices = Office::select(['office_code', 'id'])->pluck('office_code', 'id');

        $query = Target::query()->with(['sub_targets.user_tasks']);

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
                        'ave' => number_format(($user_task->q + $user_task->t + $user_task->e) / 3, 2),
                        "remark" => $user_task->remark,
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
        });


        return Inertia::render('OfficeTarget/Index', [
            'offices' => $offices,
            'targets' => $targets,
        ]);
    }
}
