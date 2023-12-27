<?php

namespace App\Http\Requests\Apis;

use Illuminate\Foundation\Http\FormRequest;

class TransportationsignsRequest extends FormRequest
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
            'ticketId' => 'required|numeric|exists:transportations,id',
            'userId' => 'required|numeric|exists:accounts,id',
            'shipperSignature' => 'file|mimes:jpg,png,jpeg',
            'customerSignature' => 'file|mimes:jpg,png,jpeg',
            'driverSignature' => 'file|mimes:jpg,png,jpeg',
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
