<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Auth\Models\User;

class LoginController extends Controller
{
    public function loginUser(LoginUserRequest $request)
    {
        $user = User::where(['email' => $request->get('login')])->first();
        if (! $user) {
            return response()->json(['errors' => 'something happened during login'], 400);
        } else {
            if (bcrypt($request->get('password')) != $user->password) {
                return response()->json(['errors' => 'invalid password'], 400);
            }

            if ($user->email_verified_at == null) {
                return response()->json(['errors' => 'email not verified', 'action' => 'send code'], 400);
            }

            $token = $user->createToken('Bearer');
            $user->save();

            return response()->json(['errors' => 'no', 'token' => $token->plainTextToken, 'user_login' => $user->email], 200);
        }
    }
}
