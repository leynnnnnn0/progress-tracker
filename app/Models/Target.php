<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    /** @use HasFactory<\Database\Factories\TargetFactory> */
    use HasFactory;

    protected $fillable = [
        'percentage_group',
        'description',
    ];

    public function sub_targets()
    {
        return $this->hasMany(SubTarget::class);
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
