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
            'specificationsAndRemarks' => 'nullable|string',
            'customer' => 'required|string', // R
            'location' => 'required|string', // R
            'poNumber' => 'nullable|string',
            'date' => 'required|date', // R
            'startJob' => 'required|string', // R
            'arrivalYard' => 'nullable|string',
            'travelTime' => 'nullable|string|numeric',
            'totalHours' => 'required|numeric', // R
            'rating' => 'nullable|string|numeric',
            'operator' => 'nullable|string',
            'emailAddress' => 'required|email', // R
            'notesOthers' => 'nullable|string',
            'leaveYard' => 'required|string', // R
            'finishJob' => 'required|string', // R
            'lunch' => 'nullable|string',
            'craneTime' => 'nullable|string',
            'craneNumber' => 'nullable|string',
            'boomLength' => 'nullable|string',
            'otherEquipment' => 'nullable|string',
            'isPayDuty' => 'required|boolean', // R
            'imageFiles.*' => 'file|mimes:jpg,png,jpeg',
            'signature' => 'required|file|mimes:jpg,png,jpeg', // R
            'jobId' => 'required|numeric|exists:jobs,id', // R
            'userId' => 'required|numeric|exists:accounts,id', // R
            // Payduty Fields
            'pdDate' => 'required_if:isPayDuty,1|date', // R
            'pdLocation' => 'required_if:isPayDuty,1|string', // R
            'pdStartTime' => 'nullable|string',
            'pdFinishTime' => 'nullable|string',
            'pdTotalHours' => 'nullable|numeric',
            'pdOfficer' => 'nullable|string',
            'pdOfficerName' => 'required_if:isPayDuty,1|string', // R
            'pdDivision' => 'nullable|numeric',
            'pdEmailAddress' => 'required_if:isPayDuty,1|email', // R
            'pdSignature' => 'required_if:isPayDuty,1|file|mimes:jpg,png,jpeg', // R
        ];
    }

    public function messages()
    {
        return [
            "pdDate.required_if" => "The payduty date is required",
            "pdLocation.required_if" => "The payduty location is required",
            "pdOfficerName.required_if" => "The payduty officer name is required",
            "pdEmailAddress.required_if" => "The payduty email is required",
            "pdSignature.required_if" => "The payduty signature is required",
            "pdDivision.numeric" => "The payduty division should be in number",
            "pdTotalHours.numeric" => "The payduty total hours should be in number",
            "pdEmailAddress.email" => "The payduty email address must be a valid email address",
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
