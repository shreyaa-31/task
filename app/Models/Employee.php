<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Employee extends Authenticatable
{
    protected $guard= 'employee';

    protected $table= 'employees';
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'emp_name','mobile','email','dept_id','gender','DOB','emp_joining_date','password',
       
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getDept(){
        return $this->hasOne(Department::class, 'id', 'dept_id');
    }
}
