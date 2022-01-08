<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;

class UpdateController extends Controller
{

  public function edit(Request $request)
  {
   
    $data['user'] = User::find($request->id);
   
    $data['subcategory'] = Subcategory::where('category_id',$data['user']['category_id'])->get(['subcategory_name', 'id']);
 
    return response()->json(['status' => true, 'data' => $data]);
  }
  public function update(UpdateRequest $request)
  {
  
    $data = User::find($request->id);

    $data->firstname = $request->input('firstname');
    $data->lastname = $request->input('lastname');
    $data->email = $request->input('email');
    $data->category_id = $request->input('category');
    $data->subcategory_id = $request->input('subcategory');
    if ($profile = $request->file('profile')) {
      $destinationPath = 'storage/images/';
      $profileImage = date('YmdHis') . "." . $profile->getClientOriginalExtension();
      $profile->move($destinationPath, $profileImage);

      $data->profile = "$profileImage";
    }
    $data->update();
    return response()->json(['status' => true, 'message' => 'Update Success']);
  }
}



