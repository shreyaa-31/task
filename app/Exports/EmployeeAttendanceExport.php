<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeAttendanceExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        // dd($data['id']);
        $this->id = $data['id'];
        $this->daterange = $data['daterange'];
    }


    public function view(): View
    {
        $daterange = explode('-', $this->daterange);
        $d1 = $daterange[0];
        $d2 = $daterange[1];

        $date1 = date('Y-m-d', strtotime($d1));
        $date2 = date('Y-m-d', strtotime($d2));

        $data['name'] = Employee::where('id',$this->id)->get('emp_name');
       

        $diff = EmployeeAttendance::select('date', 'comment', 'start_time', 'end_time')->where('emp_id', $this->id)->whereBetween('date', [$date1, $date2])->get()->toArray();
        // dd($diff);


        foreach ($diff as $d) {
            $d1 = strtotime($d['start_time']);
            $d2 = strtotime($d['end_time']);
            $difference = 0;

            $di = abs($d2 - $d1);
            $difference = $di / 60 / 60 + $difference;
            $working_hr = floor($difference);
            $working_min = round(($difference - $working_hr) * 60);
            $date[] = $d['date'];
            $cmnt[] = $d['comment'];
            $total[] =  $difference;
            $dd[] = $working_hr . "hr" . " " . $working_min . "min";
        }
        for($i= 0; $i<count($dd); $i++){
            $diff[$i]['diff'] = $dd[$i]; 
        }

        $time = array_sum($total);
        $hr = floor($time);

        $min = round(($time - $hr) * 60);

        $data['total_hr'] = $hr . "hr" . " " . $min . "min";

        return view('employees.emp-show', compact('data','diff'));
    }
}
