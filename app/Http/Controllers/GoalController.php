<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::paginate(10);
        return Inertia::render('Objective/Index', [
            'goals' => $goals
        ]);
    }
}
