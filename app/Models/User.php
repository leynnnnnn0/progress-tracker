<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        return $this->hasMany(UserTask::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $subTasks = SubTarget::pluck('id')->toArray();
            foreach ($subTasks as $task) {

                UserTask::create([
                    'sub_target_id' => $task,
                    'user_id' => $user->id
                ]);
            }
        });
    }
}
