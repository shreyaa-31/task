<?php

use Illuminate\Http\Request;



function getImage($image){
    // dd(1);
    $imageName = time() . '.' . $image->extension();
    $image->move(public_path('storage/images'), $imageName);
    
    if (!empty($imageName)) {
        return $imageName;
    }
    return false;
}


?>