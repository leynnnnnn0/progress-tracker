<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;

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
        'email',
        'password',
        'is_admin',
        'is_active'
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
        Auth::user()->is_admin ? $query->where('is_admin', false) : $query->where('id', Auth::user()->id);
        return $query->get()->map(function ($user) {
            if (!$user) return null;
            return [
                'value' => $user->id,
                'label' => $user->full_name
            ];
        });
    }

    public function targets()
    {
        return $this->hasMany(Target::class);
    }

    public function auditEvent($event)
    {
        Audit::create([
            'user_type' => self::class,
            'user_id' => Auth::id(),
            'auditable_type' => self::class,
            'auditable_id'   => $this->id,
            'event'          => $event,
            'url'            => request()->fullUrl(),
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'created_at'     => now(),
        ]);
    }
}
