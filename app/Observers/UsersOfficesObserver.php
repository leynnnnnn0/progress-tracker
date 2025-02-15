<?php

namespace App\Observers;

use App\Models\SubTarget;
use App\Models\UsersOffices;
use App\Models\UserTask;

class UsersOfficesObserver
{
    /**
     * Handle the UsersOffices "created" event.
     */
    public function created(UsersOffices $usersOffices): void
    {
        $subTasks = SubTarget::pluck('id')->toArray();
        foreach ($subTasks as $task) {
            UserTask::create([
                'sub_target_id' => $task,
                'user_id' => $usersOffices->user_id,
                'office_id' => $usersOffices->office_id
            ]);
        }
    }

    /**
     * Handle the UsersOffices "updated" event.
     */
    public function updated(UsersOffices $usersOffices): void
    {
        //
    }

    /**
     * Handle the UsersOffices "deleted" event.
     */
    public function deleted(UsersOffices $usersOffices): void
    {
        //
    }

    /**
     * Handle the UsersOffices "restored" event.
     */
    public function restored(UsersOffices $usersOffices): void
    {
        //
    }

    /**
     * Handle the UsersOffices "force deleted" event.
     */
    public function forceDeleted(UsersOffices $usersOffices): void
    {
        //
    }
}
