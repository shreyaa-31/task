<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\UserAddress;
use Illuminate\Support\Facades\File;

use App\Models\Subcategory;

class UserController extends Controller
{
  public function dataTable(UsersDataTable $datatable)
  {
    $data = Category::get(['category_name', 'id']);
    return $datatable->render('admin.users.index', compact('data'));
  }
  public function gets(Request $request)
  {

    $data = User::where('id', $request->id)->update(['status' => $request->status]);
    if ($request->status == "1") {
      return response()->json(['status' => true, 'message' => __('lang.User Activated')]);
    } else {
      return response()->json(['status' => true, 'message' => __('lang.User Inactivated')]);
    }
  }


  public function edit(Request $request)
  {

    $data['user'] = User::find($request->id);

    $data['subcategory'] = Subcategory::where('category_id', $data['user']['category_id'])->get(['subcategory_name', 'id']);


    return response()->json(['status' => true, 'data' => $data]);
  }

  public function update(Request $request)
  {
    // $id = $request->id;
    $request->validate([
      'firstname' => 'required|regex:/^[\pL\s\-]+$/u',
      'lastname' => 'required|regex:/^[\pL\s\-]+$/u',
      'email' => Rule::unique('users')->ignore($request->id)->whereNull('deleted_at'),
      'profile' => 'image|mimes:jpeg,png,jpeg',
    ]);
    $data = User::find($request->id);
    $data->firstname = $request->input('firstname');
    $data->lastname = $request->input('lastname');
    $data->email = $request->input('email');
    $data->category_id = $request->input('category');
    $data->subcategory_id = $request->input('subcategory');
    if ($profile = $request->file('profile')) {
      $destinationPath = 'images/';
      $profileImage = date('YmdHis') . "." . $profile->getClientOriginalExtension();
      $profile->move($destinationPath, $profileImage);

      $data->profile = "$profileImage";
    }
    $data->update();
    return response()->json(['status' => true, 'message' =>__('lang.User Data Updated')]);
  }
  public function delete(Request $request)
  {

    $data = User::find($request->id);
    // dd($data);

    $image_path = $data->profile;
    // dd($image_path);
    if (File::exists($image_path)) {
      unlink($image_path);
    }
    $data->delete();
    return response()->json(['status' => true, 'message' => __('lang.Deleted')]);
  }

 
}
