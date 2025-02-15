<?php

namespace App\Observers;

use App\Models\SubTarget;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Support\Facades\DB;

class SubTargetObserver
{
    /**
     * Handle the SubTarget "created" event.
     */
    public function created(SubTarget $subTarget): void
    {
        $users = User::pluck('id')->toArray();

        DB::beginTransaction();
        foreach ($users as $user) {
            UserTask::create([
                'sub_target_id' => $subTarget->id,
                'user_id' => $user
            ]);
        }
        DB::commit();
    }

    /**
     * Handle the SubTarget "updated" event.
     */
    public function updated(SubTarget $subTarget): void
    {
        //
    }

    /**
     * Handle the SubTarget "deleted" event.
     */
    public function deleted(SubTarget $subTarget): void
    {
        //
    }

    /**
     * Handle the SubTarget "restored" event.
     */
    public function restored(SubTarget $subTarget): void
    {
        //
    }

    /**
     * Handle the SubTarget "force deleted" event.
     */
    public function forceDeleted(SubTarget $subTarget): void
    {
        //
    }
}
