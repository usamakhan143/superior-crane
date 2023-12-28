<?php

namespace App\Http\Resources\Payduty;

use Illuminate\Http\Resources\Json\JsonResource;

class PaydutyResource extends JsonResource
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
            'id' => $this->id,
            'date' => $this->date,
            'location' => $this->location,
            'startTime' => $this->startTime,
            'finishTime' => $this->finishTime,
            'totalHours' => $this->totalHours,
            'officer' => $this->officer,
            'officerName' => $this->officerName,
            'division' => $this->division,
            'email' => $this->email,
            'signature' => $this->concatenateSignUrls($this->signature),
            'riggerId' => $this->rigger_id,
            'userId' => $this->account_id
        ];
    }

    private function concatenateSignUrls($image)
    {
        if ($image != null) {
            if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
                return $image['base_url'] . $image['file_url'];
            } else {
                return $image['base_url'] . 'storage/' . $image['file_url'];
            }
        } else {
            return $image;
        }
    }
}
