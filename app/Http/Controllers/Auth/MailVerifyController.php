<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ResendVerifyCodeRequest;
use App\Http\Requests\VerifyEmailRequest;
use Auth\Models\User;
use Carbon\Carbon;
use NextApps\VerificationCode\VerificationCode;

class MailVerifyController
{
    public function verifyEmail(VerifyEmailRequest $request)
    {

        if (VerificationCode::verify($request->get('code'), $request->get('login'))) {
            $user = User::where(['email' => $request->get('login')])->first();
            $user->email_verified_at = Carbon::now();
            $token = $user->createToken($request->token_name);
            $user->save();

            return ['token' => $token->plainTextToken];
        } else {
            return response()->json(['error' => 'invalid code entered', 'action' => 'resend code'], 400);
        }
    }

    public function resendCode(ResendVerifyCodeRequest $request)
    {
        VerificationCode::send($request->get('login'));

        return response()->json(['error' => 'no', 'status' => 'code resend to '.$request->get('login')], 200);
    }
}
