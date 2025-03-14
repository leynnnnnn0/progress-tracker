<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AnswerableList extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\AnswerableListFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'sub_target_id',
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
