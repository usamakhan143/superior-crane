<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\TransportationRequest;
use App\Http\Resources\Transportation\TransportationResource;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\Job;
use App\Models\Apis\Transportation;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    private $appRoles;

    public function __construct()
    {
        $this->appRoles = Helper::getRoles();
    }

    public function getTickets(Request $request)
    {
        // Get the query params.
        $queryParams = $request->all();
        $query = Transportation::query();

        // Apply filters based on all query parameters
        foreach ($queryParams as $field => $value) {
            // Skip non-filterable parameters, adjust as needed
            if (!in_array($field, ['ticketNumber', 'poNumber', 'id', 'siteContactName', 'siteContactNumber', 'isDraft', 'jobId', 'signaturesLeft', 'customerEmail', 'customerDate', 'customerName', 'shipperDate', 'userId'])) {
                continue;
            }

            // Map 'userId' to 'account_id' if the field is 'userId'
            if ($field === 'userId') {
                $field = 'account_id';
            }
            // Map 'jobId' to 'job_id' if the field is 'jobId'
            if ($field === 'jobId') {
                $field = 'job_id';
            }

            // Apply condition to the query
            $query->where($field, 'like', "%$value%");
        }

        // Fetch the records
        $transportations = $query->get();
        $r_data = TransportationResource::collection($transportations);
        return response()->json([
            'status' => 200,
            'data' => $r_data
        ]);
    }

    public function createTicket(TransportationRequest $request)
    {
        $userRole = Account::where('id', $request->userId)->value('role');
        if ($userRole == $this->appRoles['m']) {
            $checkJob = Job::where('id', $request->jobId)->value('is_transportation');
            if ($checkJob != 1) {
                $checkScci = Job::where('id', $request->jobId)->value('is_scci');
                if ($checkScci != 0) {
                    // Check if the request has all the signatures
                    $hasAllSignatures = $request->has('signatureforcustomer') && $request->has('signatureforshipper') && $request->has('signaturefordriver');

                    // Set the isDraft value based on the presence of all signatures
                    $isDraft = $hasAllSignatures ? 0 : 1;

                    // Count the signatures that are present in the request
                    $countSigns = $request->has('signatureforcustomer') ? 1 : 0;
                    $countSigns += $request->has('signatureforshipper') ? 1 : 0;
                    $countSigns += $request->has('signaturefordriver') ? 1 : 0;

                    $signaturesLeft = 3 - $countSigns;

                    // Customer signature
                    $customerSign = $request->file('signatureforcustomer');

                    // Shipper Signature
                    $shipperSign = $request->file('signatureforshipper');

                    // Driver Signature
                    $driverSign = $request->file('signaturefordriver');

                    // Images
                    $files = $request->file('imageFiles');

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
                    $addTransportation->poNumber = $request->poNumber ?? 'NA';
                    $addTransportation->specialInstructionsForPoNumber = $request->specialInstructionsforpo ?? 'NA';
                    $addTransportation->siteContactName = $request->siteContactName ?? 'NA';
                    $addTransportation->specialInstructionsForSiteContactName = $request->specialInstructionsforconName ?? 'NA';
                    $addTransportation->siteContactNumber = $request->siteContactNumber ?? 'NA';
                    $addTransportation->specialInstructionsForSiteContactNumber = $request->specialInstructionsforconNo ?? 'NA';
                    $addTransportation->shipperName = $request->shipperName ?? 'NA';
                    $addTransportation->shipperDate = $request->dateforshipper ?? 'NA';
                    $addTransportation->shipperTimeIn = $request->timeInforshipper ?? 'NA';
                    $addTransportation->shipperTimeOut = $request->timeOutforshipper ?? 'NA';
                    $addTransportation->pickupDriverName = $request->pickUpDriverName; // R
                    $addTransportation->pickupDriverDate = $request->datefordriver; // R
                    $addTransportation->pickupDriverTimeIn = $request->timeInfordriver; // R
                    $addTransportation->pickupDriverTimeOut = $request->timeOutfordriver; // R
                    $addTransportation->customerName = $request->customerName; // R
                    $addTransportation->customerTimeIn = $request->timeInforcustomer; // R
                    $addTransportation->customerTimeOut = $request->timeOutforcustomer; // R
                    $addTransportation->customerDate = $request->dateforcustomer; // R
                    $addTransportation->customerEmail = $request->customerEmail; // R
                    $addTransportation->signaturesLeft = $signaturesLeft; // R, Number of signatures posted
                    $addTransportation->isDraft = $isDraft; // R, If any signature left from the total number of signature required in the whole ticket.
                    $addTransportation->job_id = $request->jobId; // R
                    $addTransportation->account_id = $request->userId; // R

                    $save_ticket = $addTransportation->save();
                    if ($save_ticket) {
                        $signature_data = [
                            'folderName' => 'transportation-signatures',
                            'customerImageName' => 'customer-sign',
                            'shipperImageName' => 'shipper-sign',
                            'driverImageName' => 'driver-sign',
                            'customer_file_type' => 'customer-signature',
                            'shipper_file_type' => 'shipper-signature',
                            'driver_file_type' => 'driver-signature',
                            'file_ext_type' => 'image',
                            'transportationId' => $addTransportation->id,
                            'userId' => $addTransportation->account_id,
                        ];

                        // Saving all three signatures
                        if ($countSigns > 0) {

                            // Customer
                            if ($request->has('signatureforcustomer')) {
                                // Save customer signature to folder.
                                $customerSignature = Fileupload::singleUploadFile($customerSign, $signature_data['transportationId'], $signature_data['folderName'], $signature_data['customerImageName']);
                                // Save customer signature to db.
                                Helper::addFile($customerSignature, $signature_data['customer_file_type'], $signature_data['file_ext_type'], 0, $signature_data['userId'], 0, $signature_data['transportationId'], 0);
                            }

                            // Shipper
                            if ($request->has('signatureforshipper')) {
                                // Save shipper signature to folder.
                                $shipperSignature = Fileupload::singleUploadFile($shipperSign, $signature_data['transportationId'], $signature_data['folderName'], $signature_data['shipperImageName']);
                                // Save shipper signature to db.
                                Helper::addFile($shipperSignature, $signature_data['shipper_file_type'], $signature_data['file_ext_type'], 0, $signature_data['userId'], 0, $signature_data['transportationId'], 0);
                            }

                            // Driver
                            if ($request->has('signaturefordriver')) {
                                // Save driver signature to folder.
                                $driverSignature = Fileupload::singleUploadFile($driverSign, $signature_data['transportationId'], $signature_data['folderName'], $signature_data['driverImageName']);
                                // Save driver signature to db.
                                Helper::addFile($driverSignature, $signature_data['driver_file_type'], $signature_data['file_ext_type'], 0, $signature_data['userId'], 0, $signature_data['transportationId'], 0);
                            }
                        }

                        if (is_array($files)) {
                            $image_data = [
                                'countPhoto' => count($files),
                                'folderName' => 'transportation-gallery',
                                'imageName' => 'transportation-image',
                                'file_ext_type' => 'image'
                            ];
                            // Save Images to folder.
                            $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);

                            foreach ($imageFiles as $imageFile) {
                                Helper::addFile($imageFile, $image_data['folderName'], $image_data['file_ext_type'], 0, $signature_data['userId'], 0, $signature_data['transportationId'], 0);
                            }
                        }

                        // Update isTransportation field in Job Model to indicate that Transportation Ticket is Attached with the Job.
                        Job::where('id', $addTransportation->job_id)->update([
                            'is_transportation' => 1
                        ]);
                    }

                    $saved_ticket = new TransportationResource($addTransportation);

                    if ($isDraft < 1) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Ticket submitted successfully.',
                            'isDraft' => false,
                            'data' => $saved_ticket
                        ]);
                    } else {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Saved as draft successfully.',
                            'isDraft' => true
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'The job should have SCCI enabled.'
                    ], 404);
                }
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
