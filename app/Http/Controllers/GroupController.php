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
            'core_percentage' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'strategic_percentage' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'support_percentage' => ['sometimes', 'numeric', 'min:0', 'max:100'],
        ]);

        $office = Office::with('group_percentage')->findOrFail($validated['office_id']);


        ['core_percentage' => $core_percentage, 'strategic_percentage' => $strategic_percentage, 'support_percentage' => $support_percentage] = $validated;

        $total = $core_percentage + $strategic_percentage + $support_percentage;


        if ($total > 100 || $total < 100) {
            return back()->withErrors([
                'percentage' => 'The sum of core, strategic, and support percentages must equal exactly 100%. Current total: ' . $total . '%'
            ])->withInput();
        }

        $office->group_percentage()->update([
            'core' => $core_percentage,
            'strategic' => $strategic_percentage,
            'support' => $support_percentage
        ]);

        return back()->with('success', 'Percentage updated successfully.');
    }
}
