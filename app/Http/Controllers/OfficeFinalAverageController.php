<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\SubTarget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeFinalAverageController extends Controller
{
    public function index()
    {
        $offices = Office::with(['user_tasks'])->latest()
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn($office) => [
                'id' => $office->id,
                'name' => $office->name,
                'office_code' => $office->office_code,
                'user_tasks' => $office->user_tasks->map(function ($userTask) {
                    return [
                        'sub_target_id' => $userTask->sub_target_id,
                        'average' => ($userTask->q + $userTask->t + $userTask->e) / 3
                    ];
                })
            ]);

        $subTargets = SubTarget::select(['id', 'description'])
            ->get()
            ->pluck('description', 'id');


        return Inertia::render('OfficeFinalAverage/Index', [
            'targets' => $subTargets,
            'offices' => $offices,
        ]);
    }
}
