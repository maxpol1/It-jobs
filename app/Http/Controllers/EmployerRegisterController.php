<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class EmployerRegisterController extends Controller
{

    public function employerRegister(Request $request)
    {

        $this->validate($request, [
            'cname' => 'required|string|max:60',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('cname'),
            'password' => Hash::make(request('password')),
            'user_type' => $request->input('user_type'),
        ]);
        Company::create([
            'user_id' => $user->id,
            'cname' => $request->input('cname'),
            'address' => '',
            'slug' => Str::slug($request->input('cname'))

        ]);
        //$user->sendEmailVerificationNotification();

        return redirect()->back()->with('message', 'A verification link is sent to your email. Please follow the link to verify it');


    }
}
