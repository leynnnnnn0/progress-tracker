<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::latest()->paginate(10);
        return Inertia::render('Target/Index', [
            'targets' => $targets
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
            'sub_targets' => ['required'],
        ]);

        DB::beginTransaction();
        $target = Target::create([
            'description' => $validated['description']
        ]);
        foreach ($validated['sub_targets'] as $subTarget) {
            $target->sub_targets()->create([
                'description' => $subTarget['description'],
                'target_number' => 90
            ]);
        }
        DB::commit();

        return to_route('targets.index');
    }
}
