<?php

namespace App\Http\Requests\Apis;

use Illuminate\Foundation\Http\FormRequest;

class UpdatejobRequest extends FormRequest
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
            'riggerAssigned' => 'numeric',
            'imageFiles.*' => 'file|mimes:jpg,png,jpeg',
            // 'enterBy' => 'required',
            'isSCCI' => 'boolean'
        ];
    }
    
    public function messages()
    {
        return [
            "isSCCI.boolean" => "The SCCI field must be true or false.",
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
