<?php

namespace App\Observers;

use App\Models\Office;
use App\Models\SubTarget;
use App\Models\UserTask;
use Illuminate\Support\Facades\DB;

class OfficeObserver
{
    /**
     * Handle the Office "created" event.
     */
    public function created(Office $office): void
    {
        $subTargets = SubTarget::pluck('id');
        DB::beginTransaction();
        foreach ($subTargets as $subTarget) {
            UserTask::create([
                'sub_target_id' => $subTarget,
                'office_id' => $office->id
            ]);
        }
        DB::commit();
    }

    /**
     * Handle the Office "updated" event.
     */
    public function updated(Office $office): void
    {
        //
    }

    /**
     * Handle the Office "deleted" event.
     */
    public function deleted(Office $office): void
    {
        //
    }

    /**
     * Handle the Office "restored" event.
     */
    public function restored(Office $office): void
    {
        //
    }

    /**
     * Handle the Office "force deleted" event.
     */
    public function forceDeleted(Office $office): void
    {
        //
    }
}
