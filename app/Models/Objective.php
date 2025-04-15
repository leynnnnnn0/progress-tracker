<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    /** @use HasFactory<\Database\Factories\ObjectiveFactory> */
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'description'
    ];

    public function goal()
    {
        return $this->hasMany(Goal::class);
    }
}
