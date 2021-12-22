<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\DataTables\RoleDataTable;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function dataTable(RoleDataTable $datatable)
    {
        $data = Permission::get(['id', 'name','module']);
        $module =[];
      foreach($data as $m){
          $module[] = $m['module'];
          
      }
    //   dd($data1);
        return $datatable->render('admin.roles.index', compact('data'));
    }

    public function create_role()
    {
       
        
        $permission = Permission::get();

        // dd($permission);
       
        return view('admin.roles.create',compact('permission'));
    }

    public function role_store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles')
                        ->with('success',__('lang.Role created successfully'));
    }

    public function edit_role($id)
    {
       
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
       
        return view('admin.roles.edit',compact('role','permission','rolePermissions'));
    }

    public function role_update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('admin.roles')
                        ->with('success',__('lang.Updated'));

    }
    
    public function delete_role($id){
        $role = Role::find($id);

        $role->delete();
        return redirect()->route('admin.roles')
                        ->with('success',__('lang.Deleted'));
    }
}


