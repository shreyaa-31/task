<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\DataTables\PermissionDataTable;

class PermissionController extends Controller
{
    public function dataTable(PermissionDataTable $datatable){

        return $datatable->render('admin.permissions.index');
    }

    public function edit_permission(Request $request){
        
        $data = Permission::find($request->id);

        return response()->json(['status' => true, 'data' => $data]);
    }
    public function update_permission(Request $request){
        
        $id = $request->id;
        $request->validate([
            'permission_name' => 'required',
            'guard_name' => 'required|'
            
        ]);
     
        $data = Permission::find($request->id);
        $data->name = $request->input('permission_name');
        $data->guard_name = $request->input('guard_name');

        $data->update();
        return response()->json(['status' => true, 'data' => $data,'message'=>"Permission Updated"]);
    }
    public function delete_permission(Request $request)
    {
        // dd($request->all());

        $data = Permission::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' => "Delete Successfully"]);
    }
}
