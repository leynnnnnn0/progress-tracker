<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    /** @use HasFactory<\Database\Factories\UserTaskFactory> */
    use HasFactory;

    protected $fillable = [
        'sub_target_id',
        'office_id',
        'target_number',
        'success_indicator',
        'individual_accountable',
        'actual_accomplishments',
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

    public function office()
    {
        return $this->belongTo(Office::class);
    }

    public function users_offices()
    {
        return $this->belongsTo(UsersOffices::class);
    }

}
