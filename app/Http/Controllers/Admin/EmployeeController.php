<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\EmployeeDataTable;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;


class EmployeeController extends Controller
{

    public function employee(EmployeeDataTable $datatable)
    {
        $default = array("" => __('lang.--Select--'));

        $deptvalue = Department::where('status', '1')->pluck('dept_name', 'id')->toarray();

        $dept = $default + $deptvalue;

        // dd($dept);
        return $datatable->render('employees.employee', compact('dept'));
    }


    public function emp_store(EmployeeRequest $request)
    {

        if ($request->hidden_id == "") {



            $data = new Employee;
            $data->emp_name = $request->input('emp_name');
            $data->mobile = $request->input('mobile');
            $data->email = $request->input('email');
            $data->gender = $request->input('gender');
            $data->dept_id = $request->input('dept_name');
            $data->dob = $request->input('dob');
            $data->emp_joining_date = $request->input('emp_joining_date');
            $data->password = Hash::make($request->input('password'));
            $data->save();

            return response()->json(['status' => true, 'data' => $data, 'message' => __('lang.Employee Successfully added!')]);
        } else {
            // dd(456);
            $id = $request->hidden_id;



            $data = Employee::find($request->hidden_id);

            $data->emp_name = $request->input('emp_name');
            $data->mobile = $request->input('mobile');
            $data->email = $request->input('email');
            $data->gender = $request->input('gender');
            $data->dept_id = $request->input('dept_name');
            $data->dob = $request->input('dob');
            $data->emp_joining_date = $request->input('emp_joining_date');
            $data->password = Hash::make($request->input('password'));
            $data->update();

            return response()->json(['status' => true, 'message' => __('lang.Updated')]);
        }
    }

    public function delete_emp(Request $request)
    {

        $data = Employee::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' => __('lang.Deleted')]);
    }

    public function get_emp_details(Request $request)
    {

        $data = Employee::find($request->id);
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function change_status(Request $request)
    {

        $data = Employee::where('id', $request->id)->update(['status' => $request->status]);
        if ($request->status == "1") {
            return response()->json(['status' => true, 'message' => __('lang.Activated')]);
        } else {
            return response()->json(['status' => true, 'message' => __('lang.Inactivated')]);
        }
    }

    public function checkmail(Request $request)
    {
        if (!empty($request->hidden_id)) {
            
        
            $user_exists = Employee::where('email',$request->email)
            ->where('id', $request->hidden_id)->get();
           
            if (!empty($user_exists)) {
                return "true";
            } else {
                return "false";
            }
        } else {

            $user_exists = Employee::where('email', $request->email)->first();
           
            if (empty($user_exists)) {
                return "true";
            } else {
                return "false";
            }
        }
        
    }

    public function checkmobile(Request $request)
    {
        //   dd($request->all());
        if (!empty($request->hidden_id)) {

            $user_exists = Employee::where('mobile',$request->mobile)
            ->where('id', $request->hidden_id)->get();
           
            if (!empty($user_exists)) {
                return "true";
            } else {
                return "false";
            }
        } else {

            $user_exists = Employee::where('mobile', $request->mobile)->first();

            if (empty($user_exists)) {
                return "true";
            } else {
                return "false";
            }
        }
    }
}
