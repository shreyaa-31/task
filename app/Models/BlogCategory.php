<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'blogcategories';

    protected $fillable = [
        'id',
        'name',
        'status',
        'created_at'
    ];

    protected $hidden = [
        'updated_at',
    ];
}
