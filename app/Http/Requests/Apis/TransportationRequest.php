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
            'timeIn' => 'string',
            'timeOut' => 'string',
            'notes' => 'string',
            'specialInstructionsforjob' => 'string',
            'poNumber' => 'numeric',
            'specialInstructionsforpo' => 'string',
            'siteContactName' => 'string',
            'specialInstructionsforconName' => 'string',
            'siteContactNumber' => 'string',
            'specialInstructionsforconNo' => 'string',
            'shipperName' => 'string',
            'signatureforshipper' => 'file|mimes:jpg,png,jpeg',
            'dateforshipper' => 'string',
            'timeInforshipper' => 'string',
            'timeOutforshipper' => 'string',
            'pickUpDriverName' => 'string',
            'signaturefordriver' => 'file|mimes:jpg,png,jpeg',
            'datefordriver' => 'date',
            'timeInfordriver' => 'string',
            'timeOutfordriver' => 'string',
            'customerName' => 'string',
            'customerEmail' => 'email',
            'signatureforcustomer' => 'file|mimes:jpg,png,jpeg',
            'dateforcustomer' => 'string',
            'timeInforcustomer' => 'string',
            'timeOutforcustomer' => 'string',
            'imageFiles.*' => 'file|mimes:jpg,png,jpeg',
            'isDraft' => 'required|boolean',
            'userId' => 'required|numeric|exists:accounts,id',
            'jobId' => 'required|numeric|exists:jobs,id'
        ];
    }
}
