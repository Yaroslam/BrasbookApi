<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyEmailRequest extends FormRequest
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
            'code' => ['required', 'string', 'size:'.config('verification-code.length'), 'regex:/[0-9]{6}/'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.email' => 'Login must be valid email',
            'login.required' => 'Login must in request',
            'code.size' => 'invalid format of code',
            'code.regex' => 'invalid format of code',
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
