<?php

namespace App\Http\Requests\Apis;

use Illuminate\Foundation\Http\FormRequest;

class SendemailRequest extends FormRequest
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
            'riggerId' => 'numeric',
            'email' => 'required|email',
            'isRigger' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            "isRigger.boolean" => "Please let me know which PDF you want me to generate and send to email by true or false.",
            "isRigger.required" => "This field is required. It should be boolean true or false.",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'status' => 422,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
