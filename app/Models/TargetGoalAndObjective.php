<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetGoalAndObjective extends Model
{
    /** @use HasFactory<\Database\Factories\TargetGoalAndObjectiveFactory> */
    use HasFactory;
    protected $fillable = [
        'target_id',
        'goal_id',
        'objective_id'
    ];


    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
