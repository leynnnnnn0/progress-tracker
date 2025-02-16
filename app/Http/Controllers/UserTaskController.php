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
}
