<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

class AuditableModel extends Audit
{
    protected $appends = [
        'dateAndTime'
    ];
    public function getDateAndTimeAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y H:i:a');
    }
}
