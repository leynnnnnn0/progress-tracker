<?php

namespace App\Models;

use App\Observers\SubTargetObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([SubTargetObserver::class])]
class SubTarget extends Model
{
    /** @use HasFactory<\Database\Factories\SubTargetFactory> */
    use HasFactory;

    protected $fillable = [
        'target_id',
        'description',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function user_tasks()
    {
        return $this->hasMany(UserTask::class);
    }

    // protected static function boooted()
    // {
    //     static::created(function ($sub_target) {
    //         $users = User::pluck('id')->toArray();

    //         foreach ($users as $user) {
    //             UserTask::create([
    //                 'sub_target_id' => $sub_target->id,
    //                 'user_id' => $user
    //             ]);
    //         }
    //     });
    // }
}
