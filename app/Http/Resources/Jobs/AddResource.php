<?php

namespace App\Http\Resources\Jobs;

use Illuminate\Http\Resources\Json\JsonResource;

class AddResource extends JsonResource
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
            'userId' => $this->account_id,
            'jobId' => $this->id,
            'jobNumber' => $this->job_number,
            'clientName' => $this->client_name,
            'jobDate' => $this->job_date,
            'jobTime' => $this->job_time,
            'address' => $this->address,
            'equipmentToBeUsed' => $this->equipment_used,
            'riggerAssigned' => $this->rigger_assigned,
            'supplierName' => $this->supplier_name,
            'notes' => $this->notes,
            'imageFiles' => $this->concatenateImageUrls($this->images->pluck('file_url')->toArray()),
            'enterBy' => $this->enter_by,
            'statusCode' => $this->status_code,
            'isSCCI' => $this->is_scci,
            'isRiggerFilled' => $this->is_rigger,
            'isTransportationFilled' => $this->is_transportation
        ];
    }

    private function concatenateImageUrls()
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
