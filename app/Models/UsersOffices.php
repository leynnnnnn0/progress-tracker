<?php

namespace App\Models;

use App\Observers\UsersOfficesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([UsersOfficesObserver::class])]
class UsersOffices extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\UsersOfficesFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'office_id'
    ];

    public function user_tasks()
    {
        return $this->hasMany(UserTask::class);
    }
}
