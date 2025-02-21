<?php

namespace App\Http\Controllers;

use App\Models\SubTarget;
use App\Models\Target;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
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
        return Inertia::render('Target/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required'],
            'percentage_group' => ['required'],
            'sub_targets' => ['required'],
        ]);


        DB::beginTransaction();
        $target = Target::create([
            'percentage_group' => $validated['percentage_group'],
            'description' => $validated['description']
        ]);
        foreach ($validated['sub_targets'] as $subTarget) {
            SubTarget::create([
                'target_id' => $target->id,
                'description' => $subTarget['description'],
            ]);
        }
        DB::commit();

        return to_route('targets.index');
    }

    public function edit(Target $target)
    {
        $target->load(['sub_targets']);
        return Inertia::render('Target/Edit', [
            'target' => $target
        ]);
    }

    public function update(Request $request, Target $target)
    {
        $validated = $request->validate([
            'description' => ['required'],
            'sub_targets' => ['required'],
        ]);

        DB::beginTransaction();
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
        DB::commit();
        return to_route('targets.index');
    }
}
