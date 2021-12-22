<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\DataTables\CategoryDataTable;
use App\Models\Category;

class CategoryController extends Controller
{

    public function dataTable(CategoryDataTable $datatable)
    {
        if(request()->ajax()) {
            return datatables()->of(Category::select('*'))
            ->addColumn('action', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-success m-1 changestatus" status ="0" id="' . $data->id . '"> <i class="fa fa-unlock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-primary   m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('category_update')) {
                $inactive .=  '<button type="button" class="btn btn-warning m-1  edit " data-toggle="modal" data-target="#editcategory" id="' . $data->id . '"> <i class="fa fa-edit"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('category_delete')) {
                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                }
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
        return view('admin.category.index');
        
    }
    public function showCategory()
    {

        return view('admin.category.index');
    }
    public function store(CategoryRequest $request)
    {
        // dd($request->all());
        $validatedData = new Category;
        $validatedData->category_name = $request->input('category_name');
        $validatedData->save();
       
        return response()->json(['status' => true, 'data' => $validatedData,'message'=> __('lang.Category Added Successfully')]);
    }
    public function changeStatus(Request $request)
    {
       
        // dd($request->status);
        $data = Category::where('id', $request->id)->update(['status' => $request->status]);
        if($request->status == "1"){
            return response()->json(['status'=>true,'message'=>__('lang.Activated')]);
        }else{
            return response()->json(['status'=>true,'message'=>__('lang.Inactivated')]);
        }
}

    public function getcategory(Request $request)
    {


        $data = Category::find($request->id);

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function updatecategory(CategoryRequest $request)
    {
        // dd($request->all());
        $id = $request->id;
        
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,'. $id,
            
        ]);
     
        $data = Category::find($request->id);
        $data->category_name = $request->input('category_name');

        $data->update();
        return response()->json(['status' => true, 'data' => $data,'message'=>__('lang.Updated')]);
    }

    public function deletecategory(Request $request)
    {
        // dd($request->all());

        $data = Category::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' => __('lang.Deleted')]);
    }
}
