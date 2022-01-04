<?php

namespace App\Repositories;
use App\Interfaces\BlogInterface;
use App\Models\BlogCategory;
use App\Models\Blog;

class BlogRepository implements BlogInterface
{
    public function store(array $array){
        
        $blog = new Blog;
        $blog->name = $array['blogname'];
        $blog->blogcategory_id = $array['blogcategory_id'];
        $blog->description = $array['description'];
        $blog->image = getImage($array['image']);
        $blog->save();
        
        return $blog;
    }
    
}
