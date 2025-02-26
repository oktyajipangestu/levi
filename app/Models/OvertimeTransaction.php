<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeTransaction extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function overtimeType()
    {
        return $this->belongsTo(OvertimeType::class);
    }
}
