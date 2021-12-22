<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id','date','start_time','end_time','comment',
       
    ];

    public function getemp(){
        return $this->hasOne(Employee::class, 'id', 'emp_id');
    }

    
}
