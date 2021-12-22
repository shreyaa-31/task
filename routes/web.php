<?php

use App\Http\Controllers\admin\auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\users\RegisterController;
use App\Http\Controllers\employees\EmployeeLoginController;
use App\Http\Controllers\users\UpdateController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\CheckStatus;
use App\Http\Middleware\CheckEmployeeStatus;
use App\Http\Controllers\users\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('blogs.index');
})->name('blogview');


Route::get('/user/register',          'users\RegisterController@showLoginForm')->name('register');
Route::get('/forget-pass',          'users\RegisterController@forget_pass')->name('forget-pass');
Route::get('/getemail',          'users\RegisterController@getemail')->name('getemail');
Route::get('/getcat',            'users\RegisterController@getcat')->name('getcat');
Route::post('store',             'users\RegisterController@store')->name('store');
Route::post('/verify_otp',             'users\RegisterController@verify_otp')->name('verify_otp');
Route::post('/verify_otp_password',             'users\RegisterController@verify_otp_password')->name('verify_otp_password');
Route::post('/password_change',             'users\RegisterController@password_change')->name('password_change');
Route::get('/enterotp/{id}',           'users\RegisterController@enterotp')->name('enterotp');


Route::get('/user/login',        'users\LoginController@showLoginForm')->name('user.login');
Route::post('/attemptLogin',     'users\LoginController@attemptLogin')->name('attemptLogin');
Route::get('user/logout',            'users\LoginController@logout')->name('user-logout');


Route::get('/employee/login',        'employees\EmployeeLoginController@index')->name('employee-login');
Route::post('/attemptEmployeeLogin',     'employees\EmployeeLoginController@attemptEmployeeLogin')->name('emp-login');
Route::post('/emp-logout',            'employees\EmployeeLoginController@emp_logout')->name('emp-logout');
Route::post('/store-attendance',           'employees\EmployeeAttendanceController@store')->name('store-attendance');
Route::post('/update-attendance',           'employees\EmployeeAttendanceController@update')->name('update-attendance');
// Route::get('/employee-dashboard',     'employees\EmployeeLoginController@showEmployeedashboard')->name('emp-dashboard')->middleware(['checkemployeestatus','employee']);
Route::group(['middleware' => ['auth:employee', 'checkemployeestatus']], function () {

    Route::get('/employee/dashboard',        'employees\EmployeeLoginController@showEmployeeDashboard')->name('employee-dashboard');
});

Route::group(['middleware' => ['auth:web', 'userrestrict']], function () {

    Route::any('/user/dashboard',         'users\DashboardController@index')->name('dashboard');
    Route::any('/edit',         'users\UpdateController@edit')->name('edit');
    Route::post('/update',         'users\UpdateController@update')->name('update');
    Route::post('/getcategory',         'users\UpdateController@getcategory')->name('getcategory');
    Route::post('/getsubcategory',         'users\UpdateController@getsubcategory')->name('getsubcategory');
});





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
