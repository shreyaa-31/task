<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Subcategory;

class UserRepository implements UserInterface
{
    public function register(array $data)
    {

        $validatedData = new User;
        $validatedData->firstname = $data['firstname'];
        $validatedData->lastname = $data['lastname'];
        $validatedData->email = $data['email'];
        $validatedData->category_id = $data['category_id'];
        $validatedData->subcategory_id = $data['subcategory_id'];
        $validatedData->profile = getImage($data['profile']);

        $validatedData->password = Hash::make($data['password']);
        $validatedData->otp = rand(1111, 9999);
        $validatedData->remember_token = md5(uniqid(rand(), true));

        $validatedData->save();

        return $validatedData;
    }


    public function edit($id)
    {
        $user = User::find($id);



        $data['user'] = $user;

        return $data;
    }

    public function update(array $data)
    {

        $user = User::find($data['id']);
        // dd($user);
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->category_id = $data['category'];
        $user->subcategory_id = $data['subcategory'];

        if (isset($data['profile'])) {
            $user->profile = getImage($data['profile']);
           
        }

        $user->save();

        return $user;
    }
}
