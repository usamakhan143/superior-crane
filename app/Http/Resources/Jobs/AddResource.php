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
            'imageFiles' => $this->images,
            'enterBy' => $this->enter_by,
            'statusCode' => $this->status_code,
            'isSCCI' => $this->is_scci
        ];
    }
}
