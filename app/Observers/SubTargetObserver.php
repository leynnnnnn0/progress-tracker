<?php

namespace App\Observers;

use App\Models\Office;
use App\Models\SubTarget;
use App\Models\User;
use App\Models\UsersOffices;
use App\Models\UserTask;
use Illuminate\Support\Facades\DB;

class SubTargetObserver
{
    /**
     * Handle the SubTarget "created" event.
     */
    public function created(SubTarget $subTarget): void
    {
        $offices = Office::select('id')->pluck('id');
        DB::beginTransaction();
        foreach ($offices as $office) {
            UserTask::create([
                'sub_target_id' => $subTarget->id,
                'office_id' => $office
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
