<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $fillable = [
        'sub_task_id',
        'user_id',
        'target_number',
        'success_indicator',
        'individual_accountable',
        'actual_accomplishments_number',
        'q',
        't',
        'e',
        'remark',
        'link_to_evidence',
        'pmt_remark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sub_target()
    {
        return $this->belongsTo(SubTarget::class);
    }
}
