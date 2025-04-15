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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => ['required']
        ]);
        $objective = Goal::findOrFail($id);
        $objective->update($validated);
        return to_route('goals.index');
    }

    public function destroy($id)
    {
        Goal::findOrFail($id)->delete();
        return to_route('goals.index');
    }
}
