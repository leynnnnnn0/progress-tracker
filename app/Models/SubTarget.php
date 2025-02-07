<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
