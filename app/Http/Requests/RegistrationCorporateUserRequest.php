<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationCorporateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'email', 'string', 'unique:users,email', 'email:dns'],
            'password' => ['required', 'string', 'min:8', 'max:25', 'regex:/(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z!@#$%^&*]+/'],
            'inn' => ['required', 'string', 'min:10', 'max:12'],
            'company_name' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'login' => str(request('login'))
                ->squish()
                ->lower()
                ->value(),
        ]);
    }

    public function messages(): array
    {
        return [
            'login.email' => 'Login must be valid email',
            'login.unique' => 'This login already taken',
            'login.dns' => 'Login must be valid email',
            'password.min' => 'minimum len of password is 8',
            'password.max' => 'maximum len of password is 25',
            'password.regex' => 'password must include A-Za-z and one spec symbol',
            'inn.numeric' => 'invalid format of inn',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'errors' => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 400));
    }
}
