<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'office_id' => ['required'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'group_name' => ['required', 'in:core,strategic,support'],
        ]);

        $office = Office::with('group_percentage')->findOrFail($validated['office_id']);
        $group = $office->group_percentage;

        $updatedValues = [
            'core' => $group->core ?? 0,
            'strategic' => $group->strategic ?? 0,
            'support' => $group->support ?? 0,
        ];

        $updatedValues[$validated['group_name']] = $validated['percentage'];

        $total = $updatedValues['core'] + $updatedValues['strategic'] + $updatedValues['support'];

        if ($total > 100) {
            return back()->withErrors([
                'percentage' => 'The sum of core, strategic, and support percentages must equal exactly 100%. Current total: ' . $total . '%'
            ])->withInput();
        }

        $office->group_percentage()->update([
            $validated['group_name'] => $validated['percentage']
        ]);

        return back()->with('success', 'Percentage updated successfully.');
    }
}
