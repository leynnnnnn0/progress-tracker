<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Objective;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function create()
    {
        return Inertia::render('Goal/Create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required'],
            'objectives' => ['required']
        ]);

        DB::beginTransaction();

        $goal = Goal::create($validated);

        foreach ($validated['objectives'] as $objective) {
            Objective::create([
                'goal_id' => $goal->id,
                'description' => $objective['description']
            ]);
        }

        DB::commit();
        return to_route('goals.index');
    }

    public function update(Request $request, $id)
    {

        return to_route('goals.index');
    }

    public function destroy($id)
    {
        Goal::findOrFail($id)->delete();
        return to_route('goals.index');
    }

    public function edit(Goal $goal)
    {
        $goal->load(['objectives']);


        return Inertia::render('Goal/Edit', [
            'goal' => $goal,
        ]);
    }


    public function show($id)
    {
        $goal = Goal::with('objectives')->findOrFail($id);
        return Inertia::render('Goal/Show', [
            'goal' => $goal
        ]);
    }
}
