<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'id',
        'user_id',
        'blog_id',
        'created_at'
    ];

    protected $hidden = [
        'updated_at',
    ];
}
