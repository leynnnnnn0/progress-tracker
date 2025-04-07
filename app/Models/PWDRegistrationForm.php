<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PWDRegistrationForm extends Model
{
    /** @use HasFactory<\Database\Factories\PWDRegistrationFormFactory> */
    use HasFactory;

    protected $table = 'pwd_registration_forms';

    protected $fillable = [
        'user_id',
        'type_of_registration',
        'processing_officer_id',
        'approving_officer_id',
        'encoder_id',
        'reporting_unit_id',
        'control_number'
    ];
}
