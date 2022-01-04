<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\Like;

class LikeController extends Controller
{
    public function addLike(Request $request)
    {
        
        $like = Like::where('blog_id', $request->id)->where('user_id', \Auth::guard('web')->user()->id)->first();

        if (empty($like)) {
            
            $like = Like::create(['blog_id' => $request->id, 'user_id' => \Auth::user()->id]);
            
            $status = true;
            $data = $like;
             
        } else {

            $like->delete();
            $status = false;
            $data = '';

            
        }
        $likecount = Blog::withCount('likes')->where('id',$request->id)->pluck('likes_count')->first();
        // dd($likecount);
        return response()->json(['status' => $status, 'data' => $data, 'like_count' => $likecount]);
    }
}
