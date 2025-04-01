<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeSpecificTarget extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeSpecificTargetFactory> */
    use HasFactory;

    protected $fillable = [
        'office_id',
        'target_id',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
