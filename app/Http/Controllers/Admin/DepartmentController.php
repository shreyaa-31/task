<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\DataTables\DepartmentDataTable;

class DepartmentController extends Controller
{
    public function getdept(DepartmentDataTable $datatable){

        return $datatable->render('admin.departments.index');
        // return view('admin.departments.index');
    }

    public function dept_store(Request $request){
        $request->validate([
            'dept_name'=>'required|unique:departments',
        ]);
        $dept = new Department;
        $dept->dept_name = $request->input('dept_name');
        $dept->save();
        return response()->json(['status' => true, 'data' => $dept,'message'=>__('lang.Department Successfully added!!')]);
    }

    public function delete_dept(Request $request){
        // dd($request->all());
        $dept = Department::find($request->id);

        $dept->delete();
        return response()->json(['status' => true, 'message' => __('lang.Deleted')]);
    }

    public function edit_dept(Request $request){
        // dd($request->all());
        
        $dept = Department::find($request->id);

        
        return response()->json(['status' => true, 'data' =>$dept]);
    }

    public function update_dept(Request $request){
        // dd($request->all());
        $id = $request->id;
        $request->validate([
            'dept_name'=>'required|unique:departments,dept_name,'.$id,
        ]);
        $dept = Department::find($request->id);
        $dept->dept_name=$request->dept_name;
        $dept->update();
        
        return response()->json(['status' => true, 'message' =>__('lang.Updated')]);
    }

    public function changestatus(Request $request)
    {
        $data = Department::where('id', $request->id)->update(['status' => $request->status]);
        if($request->status == "1"){
            return response()->json(['status'=>true,'message'=>__('lang.Activated')]);
        }else{
            return response()->json(['status'=>true,'message'=>__('lang.Inactivated')]);
        }
    }
}
