<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Target;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TargetAccomplishedController extends Controller
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
                            'actual_accomplishments_number' => $item->actual_accomplishments_number
                        ];
                    })
                ];
            });
            return [
                'description' => $item->description,
                'sub_targets' => $sub_targets
            ];
        });
        return Inertia::render('TargetAccomplished/Index', [
            'offices' => $offices,
            'targets' => $targets,
        ]);
    }
}
