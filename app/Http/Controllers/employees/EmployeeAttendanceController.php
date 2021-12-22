<?php

namespace App\Http\Controllers\employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Carbon;

class EmployeeAttendanceController extends Controller
{
    public function store(Request $request)
    {

        $data = new EmployeeAttendance;
        $data->emp_id = $request->id;
        $data->comment = $request->comment;
        $data->date = date('Y-m-d');
        $data->start_time = date('H:i:s');
        $data->save();
        return response()->json(['status' => true, 'data' => $data, 'message' => "You are clock in"]);
    }

    public function update(Request $request)
    {

        $data = EmployeeAttendance::where('id', $request->id)->where('start_time', '!=', '')->get();


        if ($data != '') {
            $data = EmployeeAttendance::find($request->id);
            $data->end_time = date('H:i:s');
            $data->update();
            return response()->json(['status' => true, 'message' => "You are clock Out"]);
        } else {
            return response()->json(['status' => false, 'message' => "You are not clock in yet!!!"]);
        }
    }
}
