<?php

namespace App\Observers;

use App\Models\SubTarget;

class SubTargetObserver
{
    /**
     * Handle the SubTarget "created" event.
     */
    public function created(SubTarget $subTarget): void
    {
        dd($subTarget);
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
