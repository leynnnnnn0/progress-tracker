<?php

namespace App\Models;

use App\Observers\UsersOfficesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([UsersOfficesObserver::class])]
class UsersOffices extends Model
{
    /** @use HasFactory<\Database\Factories\UsersOfficesFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id'
    ];

    public function user_tasks()
    {
        return $this->hasMany(UserTask::class);
    }
}
