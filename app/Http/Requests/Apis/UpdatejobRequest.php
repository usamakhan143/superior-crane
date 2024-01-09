<?php

namespace App\Http\Requests\Apis;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $status = ['goodTogo', 'onHold', 'inProblem'];
        return [
            'riggerAssigned' => 'nullable|numeric',
            'imageFiles.*' => 'file|mimes:jpg,png,jpeg',
            // 'enterBy' => 'required',
            'statusCode' => [
                Rule::in($status)
            ],
            'isSCCI' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            "isSCCI.boolean" => "The SCCI field must be true or false.",
            "statusCode.in" => "There are only three status available in the system: goodTogo, onHold, inProblem"
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
