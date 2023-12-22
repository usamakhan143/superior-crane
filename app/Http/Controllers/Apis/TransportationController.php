<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\TransportationRequest;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\Transportation;

class TransportationController extends Controller
{
    private $appRoles;

    public function __construct()
    {
        $this->appRoles = Helper::getRoles();
    }
    
    public function createTicket(TransportationRequest $request) {
        
        return response()->json([
            'status' => 200,
            'message' => 'Ticket submitted successfully.',
            'data' => $request->all()
        ]);
        $userRole = Account::where('id', $request->userId)->value('role');
        if ($userRole == $this->appRoles['m']) {
            $checkJob = Job::where('id', $request->jobId)->value('is_transportation');
            if ($checkJob != 1) {
                // Images
                $files = $request->file('imageFiles');
                // Customer signature
                $customerSign = $request->file('signatureforcustomer');
                // Shipper Signature
                $shipperSign = $request->file('signatureforshipper');
                // Driver Signature
                $driverSign = $request->file('signaturefordriver');

                if (is_array($files)) {
                    $image_data = [
                        'countPhoto' => count($files),
                        'folderName' => 'transportation-gallery',
                        'imageName' => 'transportation-image'
                    ];
                    // Save Images to folder.
                    $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);
                }

                // Generate a 4-digit random string
                $ticketNumber = mt_rand(1000, 9999);

                // Check if the generated number is unique, if not, regenerate until it is
                while (Transportation::where('ticketNumber', $ticketNumber)->exists()) {
                    $ticketNumber = mt_rand(1000, 9999);
                }

                $addTransportation = new Transportation();
                $addTransportation->ticketNumber = $ticketNumber; // R = required
                $addTransportation->pickupAddress = $request->pickupAddress; // R
                $addTransportation->deliveryAddress = $request->deliveryAddress ?? 'NA';
                $addTransportation->billingAddress = $request->billingAddress; // R
                $addTransportation->TimeIn = $request->timeIn ?? 0;
                $addTransportation->TimeOut = $request->timeOut ?? 0;
                $addTransportation->notes = $request->notes ?? 'NA';
                $addTransportation->specialInstructionsForJobNumber = $request->specialInstructionsforjob ?? 'NA';
                $addTransportation->poNumber = $request->poNumber;
                $addTransportation->specialInstructionsForPoNumber = $request->specialInstructionsforpo;
                $addTransportation->siteContactName = $request->siteContactName;
                $addTransportation->specialInstructionsForSiteContactName = $request->specialInstructionsforconName;
                $addTransportation->siteContactNumber = $request->siteContactNumber;
                $addTransportation->specialInstructionsForSiteContactNumber = $request->specialInstructionsforconNo;
                $addTransportation->shipperName = $request->shipperName;
                $addTransportation->shipperDate = $request->dateforshipper;
                $addTransportation->shipperTimeIn = $request->timeInforshipper;
                $addTransportation->shipperTimeOut = $request->timeOutforshipper;
                $addTransportation->pickupDriverName = $request->pickUpDriverName; // R
                $addTransportation->pickupDriverDate = $request->datefordriver; // R
                $addTransportation->pickupDriverTimeIn = $request->timeInfordriver; // R
                $addTransportation->pickupDriverTimeOut = $request->timeOutfordriver; // R
                $addTransportation->customerName = $request->customerName; // R
                $addTransportation->customerTimeIn = $request->timeInforcustomer; // R
                $addTransportation->customerTimeOut = $request->timeOutforcustomer; // R
                $addTransportation->customerDate = $request->dateforcustomer; // R
                $addTransportation->customerEmail = $request->customerEmail; // R
                $addTransportation->signaturesLeft = 8; // Number of signatures posted
                $addTransportation->isDraft = $isDraft; // If any signature left from the total number of signature required in the whole ticket.
                $addTransportation->job_id = $request->jobId; // R
                $addTransportation->account_id = $request->userId; // R

                return response()->json([
                    'status' => 200,
                    'message' => 'Ticket submitted successfully.',
                    'data' => $request->all()
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'This job has already a transportation ticket submitted.'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized for this action.'
            ], 401);
        }
    }
}
