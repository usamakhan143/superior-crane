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
            'customer' => 'string',
            'location' => 'string',
            'poNumber' => 'string',
            'date' => 'date',
            'startJob' => 'string',
            'arrivalYard' => 'string',
            'travelTime' => 'string',
            'totalHours' => 'string',
            'rating' => 'string',
            'operator' => 'string',
            'emailAddress' => 'email',
            'notesOthers' => 'string',
            'leaveYard' => 'string',
            'finishJob' => 'string',
            'lunch' => 'string',
            'craneTime' => 'string',
            'craneNumber' => 'string',
            'boomLength' => 'string',
            'otherEquipment' => 'string',
            'otherEquipment' => 'string',
            'isPayDuty' => 'required|boolean',
            'jobId' => 'required|numeric|exists:jobs,id',
            'userId' => 'required|numeric|exists:accounts,id',
        ];
    }
}
