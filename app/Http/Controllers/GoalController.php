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
        return Inertia::render('Goal/Index', [
            'goals' => $goals
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required']
        ]);

        Goal::create($validated);
        return to_route('goals.index');
    }
}
