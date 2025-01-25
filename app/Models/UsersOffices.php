<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersOffices extends Model
{
    /** @use HasFactory<\Database\Factories\UsersOfficesFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id'
    ];
}
