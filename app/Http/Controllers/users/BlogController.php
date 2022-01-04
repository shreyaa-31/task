<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Interfaces\BlogInterface;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BlogRepository;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(BlogRepository $data)
    {
        $this->blog = new BlogRepository($data);
    }

    public function index()
    {
        
        $blog = BlogCategory::where('status', 1)->get();



        return view('blogs.create',compact('blog'));
    }

    public function store(BlogRequest $request)
    {
        $blog = $this->blog->store($request->all());
       
        if (!empty($blog)) {

            return response()->json(['status' => true, 'data' => $blog, 'message' => 'Blog Created']);
        } else {

            return response()->json(['status' => false, 'message' => 'Something went Wrong']);
        }
    }

    public function viewBlog(Blog $blog)
    {

        if (!empty(Auth::guard('web')->user()->id)) {
            $like = Like::where(['user_id' => Auth::guard('web')->user()->id, 'blog_id' => $blog->id])->first();

            $likecount = Blog::withCount(['likes', 'comments'])->where('id', $blog->id)->get();

            $comments = Comment::with('getName')->where('blog_id', $blog->id)->get();
            // dd($comments[0]['created_at']->diffforHumans());

            if (empty($like)) {

                $like = '';
                return view('blogs.single-blog', compact('blog', 'like', 'likecount', 'comments'));
            } else {
                return view('blogs.single-blog', compact('blog', 'like', 'likecount', 'comments'));
            }
        } else {
            return redirect()->route('user.login');
        }
    }

    public function blogs()
    {
        $blogs = Blog::withCount(['likes', 'comments'])->get();

        $data['user'] = User::find($request->id);
   
        $data['subcategory'] = Subcategory::where('category_id',$data['user']['category_id'])->get(['subcategory_name', 'id']);

        return view('blogs.index', compact('blogs','data'));
    }
}
