<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'id',
        'user_id',
        'blog_id',
        'comments',
        'created_at'
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function getName(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
