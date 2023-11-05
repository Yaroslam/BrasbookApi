<?php

namespace App\Http\Controllers\Auth;


use Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use NextApps\VerificationCode\VerificationCode;

class RegisterController
{

    public function registerDefaultUser(Request $request)
    {
        $user = User::where(["email" => $request->get("login"), "email_verified_at" => null])->first();
        if (!$user) {
            $data = $request->validate([
                "login" => ['required', 'email', 'string', 'unique:users,email'],
                "password" => ['required', 'string'],
            ]);


            $user = User::create([
                "email" => $data["login"],
                "password" => bcrypt($data["password"]),
            ]);


        }

        if($user)
        {
            var_dump($user->email);
            VerificationCode::send("vestnik700@gmail.com");
        }

    }


    public function registerCorporateUser(Request $request)
    {
        $data = $request->validate([
            "login" => ['required', 'email', 'string', 'unique:users,email'],
            "password" => ['required', 'string'],
            "inn" => ["required"],
        ]);
        $user = User::where(["email" => $data["login"]]);
        var_dump($user->email);
        if (!$user) {
            $user = User::create([
                "email" => $data["login"],
                "password" => bcrypt($data["password"])
            ]);
        }

        if($user)
        {
            VerificationCode::send($user->email);
        }




    }



}
