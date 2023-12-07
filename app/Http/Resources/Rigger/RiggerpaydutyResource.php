<?php

namespace App\Http\Resources\Rigger;

use Illuminate\Http\Resources\Json\JsonResource;

class RiggerpaydutyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'specificationsAndRemarks' => $this->specificationsAndRemarks,
            'customer' => $this->customer,
            'location' => $this->location,
            'poNumber' => $this->poNumber,
            'date' => $this->date,
            'startJob' => $this->startJob,
            'arrivalYard' => $this->arrivalYard,
            'travelTime' => $this->travelTime,
            'totalHours' => $this->totalHours,
            'rating' => $this->rating,
            'operator' => $this->operation,
            'emailAddress' => $this->emailAddress,
            'notesOthers' => $this->notesOthers,
            'leaveYard' => $this->leaveYard,
            'finishJob' => $this->finishJob,
            'lunch' => $this->lunch,
            'craneTime' => $this->craneTime,
            'craneNumber' => $this->craneNumber,
            'boomLength' => $this->boomLength,
            'otherEquipment' => $this->otherEquipment,
            'isPayDuty' => $this->isPayDuty,
            'imageFiles' => $this->concatenateImagesUrls(),
            'signature' => $this->concatenateSignUrls($this->signature),
            'jobId' => $this->job_id,
            'userId' => $this->account_id,
            'pdDate' => $this->payDuty->date,
            'pdLocation' => $this->payDuty->location,
            'pdStartTime' => $this->payDuty->startTime,
            'pdFinishTime' => $this->payDuty->finishTime,
            'pdTotalHours' => $this->payDuty->totalHours,
            'pdOfficer' => $this->payDuty->officer,
            'pdOfficerName' => $this->payDuty->officerName,
            'pdDivision' => $this->payDuty->division,
            'pdEmailAddress' => $this->payDuty->email,
            'pdSignature' => $this->concatenateSignUrls($this->payDuty->signature)
        ];
    }

    private function concatenateSignUrls($image)
    {
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
             return $image['base_url'] . $image['file_url'];
        } else {
            return $image['base_url'] . $image['file_url'];
        }
    }

    private function concatenateImagesUrls()
    {
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            return $this->images->map(function ($image) {
                return $image['base_url'] . $image['file_url'];
            })->toArray();
        } else {
            return $this->images->map(function ($image) {
                return $image['base_url'] . 'storage/' . $image['file_url'];
            })->toArray();
        }
    }
}
