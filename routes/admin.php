
<?php


use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {
    # Login Routes
    Route::get('login',     'LoginController@showLoginForm')->name('login');
    Route::post('login',    'LoginController@login');
    Route::post('logout',   'LoginController@logout')->name('logout');
});

Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('/dashboard',                   'DashboardController@showDashboared')->name('dashboard');



    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('category',                   'CategoryController@showCategory')->name('showCategory');
        Route::get('/',                           'CategoryController@dataTable')->name('dataTable')->middleware('permission:category_view');

        Route::post('store',                       'CategoryController@store')->name('store')->middleware('permission:category_create');;;
        Route::post('/getstatus',                   'CategoryController@changeStatus')->name('getstatus');
        Route::post('/getcategory',                   'CategoryController@getcategory')->name('getcategory');
        Route::post('/updatecategory',                   'CategoryController@updatecategory')->name('updatecategory')->middleware('permission:category_update');
        Route::post('/deletecategory',                   'CategoryController@deletecategory')->name('deletecategory')->middleware('permission:category_delete');
    });
    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function () {
        Route::get('subcategory',                   'SubCategoryController@showCategory')->name('subcategory');
        Route::get('/',                             'SubCategoryController@dataTable')->name('dataTable')->middleware('permission:subcategory_view');
        Route::post('store',                        'SubCategoryController@store')->name('store')->middleware('permission:subcategory_create');
        Route::post('/getstatus',                   'SubCategoryController@changeStatus')->name('getstatus');
        Route::post('/edit',                   'SubCategoryController@edit')->name('edit');
        Route::post('/updatesubcategory',                   'SubCategoryController@updatesubcategory')->middleware('permission:subcategory_update')->name('updatesubcategory');
        Route::post('/deletesubcategory',                   'SubCategoryController@deletesubcategory')->middleware('permission:subcategory_delete')->name('deletesubcategory');
    });

    // Route::get('/getemp',                         'EmployeeController@getemp')->name('getemp');
    Route::get('/employee',                         'EmployeeController@employee')->name('employee');
    Route::post('/emp_store',                         'EmployeeController@emp_store')->name('emp_store');
    Route::post('/delete_emp',                         'EmployeeController@delete_emp')->name('delete_emp');
    Route::post('/get_emp_details',                         'EmployeeController@get_emp_details')->name('get_emp_details');
    Route::post('/checkmail',                         'EmployeeController@checkmail')->name('checkmail');
    Route::post('/checkmobile',                         'EmployeeController@checkmobile')->name('checkmobile');
    Route::post('/change-status',                          'EmployeeController@change_status')->name('change-status');

    Route::get('/employee-attendences',           'EmployeeAttendanceController@dataTable')->name('employee-attendences');
    Route::post('/delete-emp-attendences',           'EmployeeAttendanceController@delete_emp_attendences')->name('delete-emp-attendences');
    Route::post('/show-comments',           'EmployeeAttendanceController@show_comments')->name('show-comments');
    Route::post('/show',           'EmployeeAttendanceController@show')->name('show');

    Route::get('/export', 'EmployeeAttendanceController@export')->name('export');

    Route::post('/dept_store',                          'DepartmentController@dept_store')->name('dept_store')->middleware('permission:department_create');
    Route::get('/getdept',                          'DepartmentController@getdept')->name('getdept')->middleware('permission:department_view');
    Route::post('/changestatus',                          'DepartmentController@changestatus')->name('changestatus');
    Route::post('/edit_dept',                          'DepartmentController@edit_dept')->name('edit_dept');
    Route::post('/delete_dept',                          'DepartmentController@delete_dept')->name('delete_dept')->middleware('permission:department_delete');
    Route::post('/update_dept',                          'DepartmentController@update_dept')->name('update_dept')->middleware('permission:department_update');

    Route::get('/',                         'UserController@dataTable')->name('getuser')->middleware('permission:users_view');
    Route::post('/gets',                    'UserController@gets')->name('gets');
    Route::post('/edit',                    'UserController@edit')->name('edit');
    Route::post('/update',                  'UserController@update')->name('update')->middleware('permission:users_update');
    Route::post('/delete',                  'UserController@delete')->name('delete')->middleware('permission:users_delete');

    Route::post('/getstate',                 'AddressController@getstate')->name('getstate');
    Route::post('/getcity',                 'AddressController@getcity')->name('getcity');
    Route::post('/getsubcategory',                 'AddressController@getsubcategory')->name('getsubcategory');
    Route::post('/deleteAddress',                 'AddressController@deleteAddress')->name('deleteAddress');

    Route::get('/roles',                         'RoleController@dataTable')->name('roles');
    Route::get('/create-role',                         'RoleController@create_role')->name('create-role');
    Route::post('/role-store',                         'RoleController@role_store')->name('role-store');
    Route::patch('/role-update/{id}',                         'RoleController@role_update')->name('role-update');
    Route::get('/edit-role/{id}',                         'RoleController@edit_role')->name('edit-role');
    Route::get('/delete-role/{id}',                         'RoleController@delete_role')->name('delete-role');

    Route::get('/admin-user-list',                         'AdminUserController@dataTable')->name('admin-user-list');
    Route::post('/admin-store',                         'AdminUserController@admin_store')->name('admin-store');
    Route::post('/get-admin-data',                         'AdminUserController@getAdminData')->name('get-admin-data');
    Route::post('/admin-update',                         'AdminUserController@admin_update')->name('admin-update');
    Route::post('/admin-delete',                         'AdminUserController@admin_delete')->name('admin-delete');

    Route::get('/localization',                         'LocalizationController@index')->name('localization');
    
    Route::resource('address',    AddressController::class);

    Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {

    Route::get('/blog-category',                  'BlogCategoryController@index')->name('blog-view');
    Route::post('/blog-store',                  'BlogCategoryController@store')->name('store');
    Route::post('/blog-edit',                  'BlogCategoryController@edit')->name('edit');
    Route::post('/blog-update',                  'BlogCategoryController@update')->name('update');
    Route::post('/blog-delete',                  'BlogCategoryController@delete')->name('delete');
    Route::post('/blog-status',                  'BlogCategoryController@changestatus')->name('getstatus');



    });
    
});


?>