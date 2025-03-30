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
            'percentage' => ['required'],
            'group_name' => ['required'],
        ]);

        Office::with('group_percentage')->find($validated['office_id'])
            ->group_percentage()
            ->update([
                $validated['group_name'] => $validated['percentage']
            ]);

        return back();
    }
}
