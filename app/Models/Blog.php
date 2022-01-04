<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;


class Blog extends Model
{
    use HasFactory;


    protected $table = 'blogs';

    protected $fillable = [
        'id',
        'name',
        'blogcategory_id',
        'description',
        'blogimage',
        'created_at'
    ];

    protected $hidden = [
        'updated_at',
    ];
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
