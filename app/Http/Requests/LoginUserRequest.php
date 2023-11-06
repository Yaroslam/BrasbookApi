<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LoginUserRequest extends FormRequest
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
            'login' => ['required', 'email', 'string', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:25', 'regex:/(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z!@#$%^&*]+/'],
            'token_name' => ['required', Rule::in(['Bearer'])],
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
