<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'is_admin'
    ];

    protected $appends = ['full_name', 'offices_array'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getOfficesArrayAttribute()
    {
        return $this->offices->pluck('id')->toArray();
    }

    public function offices()
    {
        return $this->belongsToMany(Office::class, 'users_offices');
    }

    public function user_tasks()
    {
        return $this->hasManyThrough(UserTask::class, Office::class);
    }

    public function scopeGetOptions(Builder $query)
    {

        return Auth::user()->is_admin ?  $query->where('is_admin', false)->get()->map(function ($user) {
            if (!$user) return null;
            return [
                'value' => $user->id,
                'label' => $user->full_name
            ];
        })->filter() : null;
    }
}
