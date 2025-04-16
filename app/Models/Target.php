<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Target extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\TargetFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'created_by_id',
        'group',
        'description',
    ];

    protected $appends = ['offices_array'];

    public function offices()
    {
        return $this->belongsToMany(
            Office::class,
            'office_specific_targets',
            'target_id',
            'office_id'
        )
            ->using(OfficeSpecificTarget::class);
    }

    public function getOfficesArrayAttribute()
    {
        return $this->offices->pluck('id')->toArray();
    }

    public function sub_targets()
    {
        return $this->hasMany(SubTarget::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    // In App\Models\Target.php
    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'target_goal_and_objectives');
    }

    public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'target_goal_and_objectives');
    }

    public function targetGoalAndObjectives()
    {
        return $this->hasMany(TargetGoalAndObjective::class);
    }

    public function user_tasks()
    {
        return $this->hasManyThrough(UserTask::class, SubTarget::class);
    }

    // protected static function booted()
    // {
    //     static::created(function ($target) {
    //         foreach ($target->sub_targets as $sub_target) {
    //             $users = User::pluck('id')->toArray();
    //             foreach ($users as $user) {
    //                 UserTask::create([
    //                     'sub_target_id' => $sub_target->id,
    //                     'user_id' => $user
    //                 ]);
    //             }
    //         }
    //     });
    // }

}
