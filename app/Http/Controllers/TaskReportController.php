<?php

namespace App\Http\Controllers;

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

        $query = Target::query()->with(['sub_targets.user_tasks']);
        $userId = $users->count() > 0 ? $users->first()['value'] : null;
        $user = request('user') ?? $userId;

        $offices = Office::getOptions($user);
        $office = request('office') ?? $offices->first()['value'];

        $query->whereHas('sub_targets.user_tasks', function (Builder $query) use ($office) {
            $query->where('office_id', $office);
        });

        $query->with(['sub_targets.user_tasks' => function ($query) use ($office) {
            $query->where('office_id', $office);
        }]);


        $targets = $query->get()->map(function ($item) {
            $sub_targets = $item->sub_targets->map(function ($item) {
                $user_task = $item->user_tasks->first();

                if (!$user_task) return [];
                $count = 0;
                if ($user_task->q > 0) $count++;
                if ($user_task->t > 0) $count++;
                if ($user_task->e > 0) $count++;

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
                        'ave' => $count > 0 ? number_format(($user_task->q + $user_task->t + $user_task->e) / $count, 2) : null,
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
        })
            ->groupBy('percentage_group');


        $validated = $request->validate([
            'selectedColumns' => ['required']
        ]);

        $pdf = Pdf::loadView('pdf.task-report', [
            'selectedColumns' => $validated['selectedColumns'],
            'targets' => $targets
        ]);
        $pdf->setOption('repeatTableHeader', false);

        return $pdf->setPaper('legal', 'landscape')->download('task-report.pdf');
    }
}
