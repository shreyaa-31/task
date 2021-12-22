<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class Admin extends Authenticatable
{
    use HasFactory,HasRoles;

    protected $guard= 'admin';

    protected $table= 'admins';


    protected $fillable = [
        'email',
        'password',
        'name',
        'assign_role'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    public function getRole(){
        return $this->hasOne(Role::class, 'id','assign_role');
    }
}
