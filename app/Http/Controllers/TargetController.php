<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Group;
use App\Models\Objective;
use App\Models\Office;
use App\Models\SubTarget;
use App\Models\Target;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TargetController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = Target::query();
        if ($search)
            $query->where('description', 'like', "%$search%");
        $targets = $query->latest()->paginate(10);

        return Inertia::render('Target/Index', [
            'targets' => $targets,
            'filters' => request()->only(['search'])
        ]);
    }

    public function create()
    {
        $goals = Goal::select('description', 'id')
            ->get()->map(function ($item) {
                return [
                    'label' => $item->description,
                    'value' => $item->id
                ];
            });
        $objectives = Objective::select('description', 'id')
            ->get()->map(function ($item) {
                return [
                    'label' => $item->description,
                    'value' => $item->id
                ];
            });
        $offices = Office::getOptions();
        return Inertia::render('Target/Create', [
            'offices' => $offices,
            'objectives' => $objectives,
            'goals' => $goals
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required'],
            'group' => ['required'],
            'sub_targets' => ['required'],
            'assignedOffices' => ['required', 'array']
        ]);

        DB::beginTransaction();
        $target = Target::create([
            'created_by_id' => Auth::id(),
            'group' => $validated['group'],
            'description' => $validated['description']
        ]);
        foreach ($validated['sub_targets'] as $subTarget) {
            SubTarget::create([
                'target_id' => $target->id,
                'description' => $subTarget['description'],
            ]);
        }

        $target->offices()->attach($validated['assignedOffices']);
        DB::commit();

        return to_route('targets.index');
    }

    public function edit(Target $target)
    {
        $offices = Office::getOptions();
        $target->load(['sub_targets', 'offices']);


        return Inertia::render('Target/Edit', [
            'target' => $target,
            'offices' => $offices
        ]);
    }

    public function update(Request $request, Target $target)
    {
        $validated = $request->validate([
            'description' => ['required'],
            'sub_targets' => ['required'],
            'assignedOffices' => ['required', 'array']
        ]);

        DB::beginTransaction();

        $submittedSubTargetIds = collect($validated['sub_targets'])
            ->pluck('id')
            ->filter()
            ->toArray();

        $target->sub_targets()
            ->whereNotIn('id', $submittedSubTargetIds)
            ->delete();

        $target->update($validated);
        foreach ($validated['sub_targets'] as $subTarget) {
            $subTarget = $target->sub_targets()->updateOrCreate(
                [
                    'id' => $subTarget['id']
                ],
                [
                    'description' => $subTarget['description'],
                ]
            );
        }

        $target->offices()->sync($validated['assignedOffices']);
        DB::commit();
        return to_route('targets.index');
    }

    public function destroy($id)
    {
        $target = Target::findOrFail($id);
        $target->delete();
        return back();
    }

    public function show($id)
    {
        $target = Target::with('sub_targets')->findOrFail($id);
        return Inertia::render('Target/Show', [
            'target' => $target
        ]);
    }
}
