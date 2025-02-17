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
            'target_number' => ['nullable'],
            'success_indicator' => ['nullable'],
            'individual_accountable' => ['nullable'],
            'actual_accomplishments' => ['nullable'],
            'actual_accomplishments_number' => ['nullable'],
            'q' => ['nullable'],
            't' => ['nullable'],
            'e' => ['nullable'],
            'remark' => ['nullable'],
            'link_to_evidence' => ['nullable'],
            'pmt_remark' => ['nullable'],
        ]);

        $userTask->update($validated);
        return to_route('tasks.index');
    }
}
