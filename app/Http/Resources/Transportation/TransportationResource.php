<?php

namespace App\Http\Resources\Transportation;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportationResource extends JsonResource
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
            'ticketNumber' => $this->ticketNumber,
            'jobNumber' => $this->job->job_number,
            'pickupAddress' => $this->pickupAddress,
            // 'deliveryAddress' => $this->deliveryAddress,
            'billingAddress' => $this->billingAddress,
            'TimeIn' => $this->TimeIn,
            'TimeOut' => $this->TimeOut,
            'notes' => $this->notes,
            'specialInstructionsForJobNumber' => $this->specialInstructionsForJobNumber,
            'poNumber' => $this->poNumber,
            'specialInstructionsForPoNumber' => $this->specialInstructionsForPoNumber,
            'siteContactName' => $this->siteContactName,
            'specialInstructionsForSiteContactName' => $this->specialInstructionsForSiteContactName,
            'siteContactNumber' => $this->siteContactNumber,
            'specialInstructionsForSiteContactNumber' => $this->specialInstructionsForSiteContactNumber,
            'imageFiles' => $this->concatenateImagesUrls(),
            // Shipper
            'shipperName' => $this->shipperName,
            'shipperDate' => $this->shipperDate,
            'shipperTimeIn' => $this->shipperTimeIn,
            'shipperTimeOut' => $this->shipperTimeOut,
            'shipperSignature' => $this->concatenateSignUrls($this->shipperSignature),
            // Driver
            'pickupDriverName' => $this->pickupDriverName,
            'pickupDriverDate' => $this->pickupDriverDate,
            'pickupDriverTimeIn' => $this->pickupDriverTimeIn,
            'pickupDriverTimeOut' => $this->pickupDriverTimeOut,
            'driverSignature' => $this->concatenateSignUrls($this->driverSignature),
            // Customer
            'customerName' => $this->customerName,
            'customerDate' => $this->customerDate,
            'customerTimeIn' => $this->customerTimeIn,
            'customerTimeOut' => $this->customerTimeOut,
            'customerEmail' => $this->customerEmail,
            'customerSignature' => $this->concatenateSignUrls($this->customerSignature),
            'signaturesLeft' => $this->signaturesLeft,
            'isDraft' => $this->isDraft,
            'jobId' => $this->job_id,
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
