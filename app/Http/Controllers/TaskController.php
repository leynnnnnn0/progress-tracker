<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $targets = Target::with('sub_targets')->get()->groupBy('percentage_group');

        return Inertia::render('Task/Index', [
            'targets' => $targets
        ]);
    }
}
