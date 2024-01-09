<?php

namespace App\Http\Requests\Apis;

use Illuminate\Foundation\Http\FormRequest;

class TransportationRequest extends FormRequest
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
            'pickupAddress' => 'required', // R
            'billingAddress' => 'required', // R
            'timeIn' => 'nullable|string',
            'timeOut' => 'nullable|string',
            'notes' => 'nullable|string',
            'specialInstructionsforjob' => 'nullable|string',
            'poNumber' => 'nullable|string',
            'specialInstructionsforpo' => 'nullable|string',
            'siteContactName' => 'nullable|string',
            'specialInstructionsforconName' => 'nullable|string',
            'siteContactNumber' => 'nullable|string',
            'specialInstructionsforconNo' => 'nullable|string',
            'shipperName' => 'nullable|string',
            'signatureforshipper' => 'file|mimes:jpg,png,jpeg',
            'dateforshipper' => 'nullable|string',
            'timeInforshipper' => 'nullable|string',
            'timeOutforshipper' => 'nullable|string',
            'pickUpDriverName' => 'required|string',
            'signaturefordriver' => 'file|mimes:jpg,png,jpeg',
            'datefordriver' => 'required|date',
            'timeInfordriver' => 'required|string',
            'timeOutfordriver' => 'required|string',
            'customerName' => 'required|string',
            'customerEmail' => 'required|email',
            'signatureforcustomer' => 'file|mimes:jpg,png,jpeg',
            'dateforcustomer' => 'required|date',
            'timeInforcustomer' => 'required|string',
            'timeOutforcustomer' => 'required|string',
            'imageFiles.*' => 'file|mimes:jpg,png,jpeg',
            'userId' => 'required|numeric|exists:accounts,id',
            'jobId' => 'required|numeric|exists:jobs,id'
        ];
    }

    public function messages()
    {
        return [
            'datefordriver.required' => 'The driver date field is required.',
            'timeInfordriver.required' => 'The driver time-in field is required.',
            'timeOutfordriver.required' => 'The driver time-out field is required.',
            'dateforcustomer.required' => 'The customer date field is required.',
            'timeInforcustomer.required' => 'The customer time-in field is required.',
            'timeOutforcustomer.required' => 'The customer time-out field is required.',
            'jobId.required' => 'The job number is required. Please select the job.'
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
