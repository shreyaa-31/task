<?php

namespace App\Http\Controllers\employees;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Carbon\Carbon;


class EmployeeLoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = "employee/dashboard/";

    public function __construct()
    {

        $this->middleware('guest:employee')->except('logout');
    }
    public function index()
    {
        if (Auth::guard('employee')->check()) {
            // dd(123);
            $date = Carbon::now()->toTimeString();
            return view('employees.emp-dashboard', compact('date'));
        } else {
            // dd(456);
            return view('employees.emp-login');
        }
    }

    public function showEmployeeDashboard()
    {
        // dd(123);
        if (Auth::guard('employee')->check()) {

            $date = Carbon::now()->toTimeString();
            return view('employees.emp-dashboard', compact('date'));
        } else {
            return redirect()->route('employee-login');
        }
    }

    public function attemptEmployeeLogin(Request $request)
    {

        if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password])) {
            

            return redirect()->intended('employee/dashboard');
        } else {
            // dd(456);
            return redirect()->route('employee-login')->withErrors("Enter valid credentials");
        }
    }

    public function emp_logout(Request $request)
    {

        $data = EmployeeAttendance::where('emp_id', $request->id)->latest()->first();

        if ($data['end_time'] == '') {

            $dt = EmployeeAttendance::find($data['id']);
            $dt->end_time = date('H:i:s');
            $dt->update();

            $this->guard('employee')->logout();

            return redirect()->route('employee-login');
        } else {
            $this->guard('employee')->logout();

            return redirect()->route('employee-login');
        }
    }
    protected function guard()
    {
        return Auth::guard('employee');
    }
}
