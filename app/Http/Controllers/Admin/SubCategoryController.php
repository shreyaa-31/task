<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SubCategoryDataTable;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Validation\Rule;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    public function dataTable(SubCategoryDataTable $datatable)
    {
        $data = Category::get(['category_name', 'id']);
        if(request()->ajax()) {
            return datatables()->of(Subcategory::select('*'))
            ->editcolumn('category_id', function ($data) {
                return $data->getCategory['category_name']??" Name not found";
            })

            ->addColumn('action', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-success changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-primary changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('subcategory_update')) {
                $inactive .=  '<button type="button" class="btn btn-warning m-1 edit" data-toggle="modal" data-target="#editsubcategory" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('subcategory_delete')) {
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
            ->rawColumns(['category_id','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.subcategory.index',compact('data'));
        
    }
    public function updatesubcategory(SubCategoryRequest $request)
    {
       


        $data = Subcategory::find($request->id);
        // dd($data);
        $data->category_id = $request->input('category_name');
        $data->subcategory_name = $request->input('subcategory_name');

        $data->update();
        return response()->json(['status' => true, 'message' => __('lang.Updated')]);
    }

    public function showCategory()
    {
        $data = Category::Join('categories', function ($join) {
            $join->on('sub_categories.id', '=', 'categories.category_id');
        })
            ->whereNull('categories.category_id');

        return view('admin.subcategory.index', ['data' => $data]);
    }

    public function store(SubCategoryRequest $request)
    {
      
        $subcategory = new Subcategory;
        $subcategory->subcategory_name = $request->input('subcategory_name');
        $subcategory->category_id = $request->input('category');
        $subcategory->save();
       
        return response()->json(['status' => true, 'data' => $subcategory,'message'=> __('lang.SubCategory Added Successfully')]);
    }

    public function changeStatus(Request $request)
    {
        //   dd($request->all());
        $data = Subcategory::where('id', $request->id)->update(['status' => $request->status]);
        if($request->status == "1"){
            return response()->json(['status'=>true,'message'=> __('lang.Activated')]);
        }else{
            return response()->json(['status'=>true,'message'=> __('lang.Inactivated')]);
        }
    }
    public function edit(Request $request)
    {
        $data = Subcategory::find($request->id);

        return response()->json(['status' => true, 'data' => $data]);
    }
    public function deletesubcategory(Request $request)
    {


        $data = Subcategory::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' =>  __('lang.Deleted')]);
    }
}
