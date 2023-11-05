<?php

namespace App\Http\Controllers\Auth;

use Auth\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use NextApps\VerificationCode\VerificationCode;

class MailVerifyController
{

    public function verifyEmail(Request $request)
    {
        $data = $request->validate([
            "login" => ['required', 'email', 'string'],
            "code" => ['required', 'string'],
        ]);
        if(VerificationCode::verify($data["code"], $data["login"]))
        {
            $user = User::where(["email" => $request->get("login")])->first();
            $user->email_verified_at = Carbon::now();
            $token = $user->createToken($request->token_name);
            $user->save();
            return ['token' => $token->plainTextToken];
        } else {
            return 300;
        }
    }


    public function resendCode(Request $request)
    {
        $data = $request->validate([
            "login" => ['required', 'email', 'string', 'unique:users,email'],
            "password" => ['required', 'string'],
        ]);

        VerificationCode::send($data["login"]);
    }
}
