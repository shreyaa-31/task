<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Carbon;
use App\Models\Employee;
use App\Exports\EmployeeAttendanceExport;
use App\DataTables\EmployeeAttendanceDataTable;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeAttendanceController extends Controller

{
    public function dataTable(EmployeeAttendanceDataTable $datatable)
    {
        $data = Employee::get(['emp_name', 'id']);
        // dd($data); 
        return $datatable->render('employees.emp-attendence', compact('data'));
    }



    public function delete_emp_attendences(Request $request)
    {
        // dd($request->all());
        $data = EmployeeAttendance::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' =>  __('lang.Deleted')]);
    }

    public function show_comments(Request $request)
    {

        $diff = EmployeeAttendance::where('date', $request->date)
            ->get(['comment', 'start_time', 'end_time']);

        $cmnt = [];
        $s1 = [];
        $s2 = [];
        $dd = [];


        foreach ($diff as $d) {
            $d1 = strtotime($d['start_time']);
            $d2 = strtotime($d['end_time']);

            if ($d2 != '') {
                $s1[] = $d['start_time'];
                $s2[] = $d['end_time'];

                $di = abs($d2 - $d1);
                $difference = $di / 60 / 60;
                $working_hr = round($difference);
                $working_min = round((round($difference, 2) - $working_hr) * 60);
                $cmnt[] = $d['comment'];
                $dd[] = $working_hr . "hr" . " " . $working_min . "min";
            } else {
                $s1[] = $d['start_time'];
                $s2[] = "Working";
                $cmnt[] = $d['comment'];
                $dd[] = "Working";
            }
        }

        $date = $request->date;
        $data['comment'] = $cmnt;
        $data['start_time'] = $s1;
        $data['end_time'] = $s2;
        $data['working_hr'] = $dd;

        return response()->json(['status' => true, 'data' => $data, 'date' => $date]);
    }


    public function show(Request $request)
    {
        $date = [];
        $cmnt = [];
        $total = [];
        $dd = [];
        if ($request->id == '' || $request->daterange == '') {
            return response()->json(['status' => false, 'message' => __('lang.Something went Wrong!!')]);
        }
        $daterange = explode('-', $request->daterange);
        $d1 = $daterange[0];
        $d2 = $daterange[1];
        $date1 = date('Y-m-d', strtotime($d1));
        $date2 = date('Y-m-d', strtotime($d2));

        if ($date1 != $date2) {
            $diff = EmployeeAttendance::where('emp_id', $request->id)->whereBetween('date', [$date1, $date2])->get()->toArray();

            if (empty($diff)) {
                return response()->json(['status' => false, 'message' => __('lang.Data not found!!')]);
            } else {

                foreach ($diff as $d) {
                    $d1 = strtotime($d['start_time']);
                    $d2 = strtotime($d['end_time']);
                    $difference = 0;
                    if ($d2 != '') {


                        $di = abs($d2 - $d1);
                        $difference = $di / 60 / 60 + $difference;
                        $working_hr = floor($difference);
                        $working_min = round(($difference - $working_hr) * 60);
                        $date[] = $d['date'];
                        $cmnt[] = $d['comment'];
                        $total[] =  $difference;
                        $dd[] = $working_hr . "hr" . " " . $working_min . "min";
                    } else {

                        $cmnt[] = $d['comment'];
                        $dd[] = "Working";
                    }
                }
                $data['export'] = $request->all();
                $data['date'] = $date;
                $data['comment'] = $cmnt;
                $data['working_hr'] = $dd;
                $time = array_sum($total);
                $hr = floor($time);

                $min = round(($time - $hr) * 60);

                $data['total_hr'] = $hr . "hr" . " " . $min . "min";



                return response()->json(['status' => true, 'data' => $data]);
            }
        } else {
            return response()->json(['status' => false, 'message' => __('lang.Enter two differnt date !!')]);
        }
    }

    public function export(Request $request)
    {
       
        // $id = $request->id;
        // $daterange = $request->daterange;

        if ($request->ajax()){
            $data = $request->all();

            Session::put('exportData', $data);

            return response()->json(['status' => true, 'data' => $data]);
        }

        $data = Session::get('exportData');

        return Excel::download(new EmployeeAttendanceExport($data), 'attendance.xlsx');
        
    }


}
