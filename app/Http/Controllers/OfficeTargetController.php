<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\SubTarget;
use App\Models\Target;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeTargetController extends Controller
{
    public function index()
    {
        $offices = Office::with('user_tasks')
            ->select(['office_code', 'id'])
            ->orderBy('id', 'asc')
            ->pluck('office_code', 'id');

        $query = Target::query()->with(['sub_targets.user_tasks']);

        $targets = $query->get()->map(function ($item) {
            $sub_targets = $item->sub_targets->map(function ($item) {
                return [
                    'sub_target_id' => $item->id,
                    'description' => $item->description,
                    'offices_target' => $item->user_tasks()->orderBy('office_id', 'asc')->get()->map(function ($item) {
                        return [
                            'office_id' => $item->office_id,
                            'target_number' => $item->target_number
                        ];
                    })
                ];
            });
            return [
                'description' => $item->description,
                'sub_targets' => $sub_targets
            ];
        });


        return Inertia::render('OfficeTarget/Index', [
            'offices' => $offices,
            'targets' => $targets,
        ]);
    }

    public function updateTargetNumber(Request $request)
    {
        $validated = $request->validate([
            'sub_target_id' => ['required'],
            'office_id' => ['required'],
            'target_number' => ['required', 'numeric', 'min:0']
        ]);
        UserTask::where('office_id', $validated['office_id'])
            ->where('sub_target_id', $validated['sub_target_id'])
            ->update([
                'target_number' => $validated['target_number']
            ]);

        return back();
    }
}
