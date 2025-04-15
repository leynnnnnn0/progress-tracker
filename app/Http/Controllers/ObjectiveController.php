<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ObjectiveController extends Controller
{
    public function index()
    {
        $objectives = Objective::paginate(10);
        return Inertia::render('Objective/Index', [
            'objectives' => $objectives
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required']
        ]);

        Objective::create($validated);
        return to_route('objectives.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => ['required']
        ]);
        $objective = Objective::findOrFail($id);
        $objective->update($validated);
        return to_route('objectives.index', [
            'objective' => $objective
        ]);
    }

    public function destroy($id)
    {
        Objective::findOrFail($id)->delete();
        return to_route('objectives.index');
    }
}
