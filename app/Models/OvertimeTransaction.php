<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeTransaction extends Model
{
    protected $fillable = [
        'employee_id',
        'overtime_date',
        'reason',
        'duration',
        'overtime_type_id',
        'status',
        'supporting_document_path',
        // Add other attributes as needed
    ];

     public function users()
    {
        return $this->belongsToMany(User::class, 'overtime_transaction_user');
    }

     public function supervisor()
    {
        return $this->belongsTo(User::class, 'employee_id','id');
    }

    public function overtimeType()
    {
        return $this->belongsTo(OvertimeType::class);
    }

    public function userProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'employee_id', 'id');
    }


}
