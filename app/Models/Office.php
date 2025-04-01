<?php

namespace App\Models;

use App\Observers\OfficeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([OfficeObserver::class])]
class Office extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'office_code',
        'remarks'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_offices');
    }

    public function group_percentage()
    {
        return $this->hasOne(Group::class);
    }

    public function sub_targets()
    {
        return $this->hasMany(SubTarget::class);
    }

    public function user_tasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->office_code})";
    }

    public function scopeGetOptions(Builder $query, $id = null)
    {
        $user = $id ? User::find($id) : Auth::user();


        $user->load(['offices']);
        if (!$user->is_admin) {

            return $user->offices->map(function ($office) {
                return [
                    'value' => $office->id,
                    'label' => $office->display_name
                ];
            });
        }

        return $query->select(['id', 'name', 'office_code'])
            ->get()
            ->map(function ($office) {
                return [
                    'value' => $office->id,
                    'label' => $office->display_name
                ];
            });
    }
}
