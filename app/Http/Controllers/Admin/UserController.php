<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\UserAddress;
use Illuminate\Support\Facades\File;
use App\Repositories\UserRepository;

use App\Models\Subcategory;

class UserController extends Controller
{

  public function __construct(UserRepository $data)
  {
    $this->user = new UserRepository($data);
  }
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
    $data = $this->user->edit($request->all());
    $subcategory = Subcategory::where('category_id', $data['user'][0]->category_id)->get(['subcategory_name', 'id']);
    return response()->json(['status' => true, 'data' => $data, 'subcategory' => $subcategory]);
  }

  public function update(RegisterRequest $request)
  {

    $data = $this->user->update($request->all());
    return response()->json(['status' => true, 'message' => __('lang.User Data Updated')]);
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
