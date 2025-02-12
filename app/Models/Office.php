<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'office_code',
        'remarks'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_offices');
    }

    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->office_code})";
    }

    public function scopeGetOptions(Builder $query)
    {
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
