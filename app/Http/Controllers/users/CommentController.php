<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class CommentController extends Controller
{
    public function addComment(Request $request){
       

        $comment = new Comment;
        $comment->user_id = Auth::guard('web')->user()->id;
        $comment->blog_id = $request->blog_id;
        $comment->comments = $request->comments;
        $comment->save();

        $commentcount = Blog::withCount('comments')->where('id',$request->blog_id)->pluck('comments_count')->first();
        // $comments = Comment::with('getName')->where('blog_id',$request->blog_id)->first();
        // $firstname = $comments->getName();
        // dd($firstname);
        if (!empty($comment)) {

            return response()->json(['status' => true, 'data' => $comment,'comment_count'=>$commentcount]);
        } else {

            return response()->json(['status' => false, 'message' => 'Something went Wrong']);
        }

        
    }
}
