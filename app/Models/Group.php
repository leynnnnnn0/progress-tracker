<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    protected $fillable = [
        'office_id',
        'core',
        'strategic',
        'support'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
