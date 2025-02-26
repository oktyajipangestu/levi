<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function overtimeTransactions()
    {
        return $this->hasMany(OvertimeTransaction::class);
    }
}
