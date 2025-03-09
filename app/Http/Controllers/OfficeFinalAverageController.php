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
                'final_average' => $office->user_tasks->count() > 0
                    ? number_format($office->user_tasks->sum(fn($user_task) => ($user_task->q + $user_task->t + $user_task->e) / 3) / $office->user_tasks->count(), 2)
                    : 0
            ]);

        return Inertia::render('OfficeFinalAverage/Index', [
            'offices' => $offices,
        ]);
    }
}
