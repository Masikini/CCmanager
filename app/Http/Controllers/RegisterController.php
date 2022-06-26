<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{

    public function changePswd(Request $request)
    {

        $updateUSer = User::firstWhere('email',$request->email);
        // $updateUSer->name=$request->name;
        $updateUSer->password = Hash::make($request->password);
        $updateUSer->save();
        Auth::logout();
        return $updateUSer;
    }

    public function register(Request $request)
    {
        $request->validate(
            // [
            //     'name' => ['required'],
            //     'email' => ['required', 'unique:users'],
            //     'password' => ['required', ' min:8', 'confirmed']
            // ]
            [
                'name' => ['required'],
                'email' => ['required', 'unique:users'],
                'password' => ['required', ' min:8']
            ]
        );

        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]

        );
    }


    public function firstUser()
    {
        return User::firstorFail();
    }
}
