<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerableList extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerableListFactory> */
    use HasFactory;


    protected $fillable = [
        'success_indicators',
        'individual_accountable',
        'actual_accomplishments_number',
        'actual_accomplishments',
        'q',
        't',
        'e',
        'remark',
        'lint_to_evidence',
        'pmt_remark',
    ];
}
