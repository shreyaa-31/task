<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\DataTables\AdminUserDataTable;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;


class AdminUserController extends Controller
{
    public function dataTable(AdminUserDataTable $datatable)
    {
        
        $data = Role::get(['name', 'id']);

        return $datatable->render('admin.admin_user.index', compact('data'));
    }
    public function admin_store(Request $request)
    {
        $this->validate($request, [
            'admin_name' => 'required',
            'admin_email' => 'required|email|unique:admins,email',
            'admin_role' => 'required'
        ]);

        $admin = new Admin;
        $admin->name = $request->input('admin_name');
        $admin->email = $request->input('admin_email');
        $admin->password = Hash::make($request->input('admin_password'));
        $admin->assign_role = $request->input('admin_role');
        $admin->assignRole($request->input('admin_role'));
        $admin->save();

        return response()->json(['status' => true, 'data' => $admin, 'message' => __('lang.User Added Successfully')]);
    }
    public function getAdminData(Request $request)
    {
        $data = Admin::find($request->id);

        return response()->json(['status' => true, 'data' => $data]);
    }
    public function admin_update(Request $request)
    {
 
        $id = $request->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'role' => 'required'
        ]);


        $admin = new Admin;
        $admin = Admin::find($request->id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->assign_role = $request->input('role');
        $admin->update();
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $admin->assignRole($request->input('role'));

        return response()->json(['status' => true, 'data' => $admin, 'message' => __('lang.Updated')]);
    }

    public function admin_delete(Request $request){
      
        $data = Admin::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' => __('lang.Deleted')]);
    }
}



