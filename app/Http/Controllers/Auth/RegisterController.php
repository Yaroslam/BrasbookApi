<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegistrationCorporateUserRequest;
use App\Http\Requests\RegistrationDefaultUserRequest;
use Auth\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use NextApps\VerificationCode\VerificationCode;

class RegisterController
{
    public function registerDefaultUser(RegistrationDefaultUserRequest $request)
    {
        $user = User::create([
            'email' => $request->get('login'),
            'password' => bcrypt($request->get('password')),
            'type' => 'default',
        ]);

        if ($user) {
            VerificationCode::send($user->email);

            return response()->json(['errors' => 'no', 'status' => 'code sent to '.$request->get('login')], 200);
        } else {
            throw new HttpResponseException(response()->json(['error' => 'something happened during registration'], 500));
        }

    }

    public function registerCorporateUser(RegistrationCorporateUserRequest $request)
    {
        $user = User::create([
            'email' => $request->get('login'),
            'password' => bcrypt($request->get('password')),
            'type' => 'corporate',
            'inn' => $request->get('inn'),
            'company_name' => $request->get('company_name'),
        ]);

        if ($user) {
            VerificationCode::send($user->email);

            return response()->json(['errors' => 'no', 'status' => 'code sent to '.$request->get('login')], 200);
        } else {
            throw new HttpResponseException(response()->json(['error' => 'something happened during registration'], 500));
        }

    }
}
