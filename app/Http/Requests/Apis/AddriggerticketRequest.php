<?php

namespace App\Http\Requests\Apis;

use Illuminate\Foundation\Http\FormRequest;

class AddriggerticketRequest extends FormRequest
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
            'specificationsAndRemarks' => 'string',
            'customer' => 'required|string',
            'location' => 'required|string',
            'poNumber' => 'string',
            'date' => 'required|date',
            'startJob' => 'required|string',
            'arrivalYard' => 'string',
            'travelTime' => 'string',
            'totalHours' => 'required|numeric',
            'rating' => 'string',
            'operator' => 'string',
            'emailAddress' => 'required|email',
            'notesOthers' => 'string',
            'leaveYard' => 'required|string',
            'finishJob' => 'required|string',
            'lunch' => 'string',
            'craneTime' => 'string',
            'craneNumber' => 'string',
            'boomLength' => 'string',
            'otherEquipment' => 'string',
            'isPayDuty' => 'required|boolean',
            'imageFiles.*' => 'file|mimes:jpg,png,jpeg',
            'signature' => 'required|file|mimes:jpg,png,jpeg',
            'jobId' => 'required|numeric|exists:jobs,id',
            'userId' => 'required|numeric|exists:accounts,id',
            // Payduty Fields
            'pdDate' => 'required_if:isPayDuty,1|date',
            'pdLocation' => 'required_if:isPayDuty,1|string',
            'pdStartTime' => 'string',
            'pdFinishTime' => 'string',
            'pdTotalHours' => 'numeric',
            'pdOfficer' => 'string',
            'pdOfficerName' => 'required_if:isPayDuty,1|string',
            'pdDivision' => 'numeric',
            'pdEmailAddress' => 'required_if:isPayDuty,1|email',
            'pdSignature' => 'required_if:isPayDuty,1|file|mimes:jpg,png,jpeg',
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
