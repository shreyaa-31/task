<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;


class BlogCategoryController extends Controller
{
    public function index(){
        if(request()->ajax()) {
            return datatables()->of(BlogCategory::select('*'))
            ->addColumn('action', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-success m-1 changestatus" status ="0" id="' . $data->id . '"> <i class="fa fa-unlock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-primary   m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                }
               
                $inactive .=  '<button type="button" class="btn btn-warning m-1  edit " data-toggle="modal" data-target="#editblog" id="' . $data->id . '"> <i class="fa fa-edit"></i></button>';
                
               
                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                
                return $inactive;
               
            })
            ->editColumn('status',function($data){
                if ($data->status == 1) {
                    return __('lang.Active');
                }else{
                    return __('lang.Inactive');
                }
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.blogs.index');
    }

    public function store(BlogCategoryRequest $request){
        $blog = new BlogCategory;
        $blog->name = $request->blog_name;
        $blog->save();

        return response()->json(['status' => true, 'data' => $blog,'message'=> __('lang.blog_add_success')]);

    }

    public function delete(Request $request){
        $blog  = BlogCategory::find($request->id);
        $blog->delete();

        return response()->json(['status' => true, 'message' => __('lang.Deleted')]);
    }

    public function update(BlogCategoryRequest $request){

        $blog = BlogCategory::find($request->id);
        $blog->name = $request->input('blog_name');

        $blog->update();
        return response()->json(['status' => true, 'data' => $blog,'message'=>__('lang.Updated')]);
    }
    public function edit(Request $request){
        $blog = BlogCategory::find($request->id);

        return response()->json(['status' => true, 'data' => $blog]);
    }
    public function changestatus(Request $request){

        $blog = BlogCategory::where('id', $request->id)->update(['status' => $request->status]);
        if($request->status == "1"){
            return response()->json(['status'=>true,'message'=>__('lang.Activated')]);
        }else{
            return response()->json(['status'=>true,'message'=>__('lang.Inactivated')]);
        }
    }
}


 