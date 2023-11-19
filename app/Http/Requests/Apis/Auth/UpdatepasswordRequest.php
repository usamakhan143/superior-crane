<?php

namespace App\Http\Requests\Apis\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatepasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:accounts,email',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.exists' => 'The email is not exist.'
        ];
    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'status' => 422,
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
