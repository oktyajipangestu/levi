<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id', 'type', 'start_date','end_date','reason','status_supervisor','status_hr'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
