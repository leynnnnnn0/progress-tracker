<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    /** @use HasFactory<\Database\Factories\TargetFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function subTargets()
    {
        return $this->hasMany(SubTarget::class);
    }
}
