<?php

namespace App\Http\Controllers;

use App\Models\UserTask;
use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    public function show(UserTask $userTask)
    {
        return json_encode($userTask);
    }

    public function update(Request $request, UserTask $userTask)
    {
        $validated = $request->validate([
            'target_number' => ['nullable', 'numeric'],
            'success_indicator' => ['nullable'],
            'individual_accountable' => ['nullable'],
            'actual_accomplishments' => ['nullable'],
            'actual_accomplishments_number' => ['nullable', 'numeric'],
            'q' => ['nullable', 'numeric', 'min:1', 'max:5'],
            't' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'e' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'remark' => ['nullable'],
            'link_to_evidence' => ['nullable'],
            'pmt_remark' => ['nullable'],
        ]);

        $userTask->update($validated);
        return back();
    }
}
