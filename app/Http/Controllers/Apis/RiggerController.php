<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\AddriggerticketRequest;
use App\Http\Resources\Rigger\RiggerpaydutyResource;
use App\Http\Resources\Rigger\RiggerResource;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\File;
use App\Models\Apis\Job;
use App\Models\Apis\Payduty;
use App\Models\Apis\Rigger;
use Illuminate\Http\Request;

class RiggerController extends Controller
{
    private $appRoles;

    public function __construct()
    {
        $this->appRoles = Helper::getRoles();
    }

    public function getRiggerTickets($id = null, Request $request)
    {
        if ($id != null) {
            $userRole = Account::where('id', $id)->value('role');
            if ($userRole == $this->appRoles['sa'] || $userRole == $this->appRoles['a']) {

                // Get the query params.
                $queryParams = $request->all();
                $query = Rigger::query();

                // Apply filters based on all query parameters
                foreach ($queryParams as $field => $value) {
                    // Skip non-filterable parameters, adjust as needed
                    if (!in_array($field, ['customer', 'poNumber', 'id', 'date', 'rating', 'emailAddress', 'jobId', 'isPayDuty', 'ticketNumber', 'userId'])) {
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
                    $query->where($field, '=', $value);
                }

                // Fetch the records
                $get_tickets = $query->get();
                $r_data = RiggerResource::collection($get_tickets);
                return response()->json([
                    'status' => 200,
                    'data' => $r_data
                ], 200);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'You are not authorized for this action.'
                ], 401);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Admin or super admin ID is required as a parameter after the endpoint.'
            ], 404);
        }
    }

    public function create_ticket(AddriggerticketRequest $request)
    {
        $userRole = Account::where('id', $request->userId)->value('role');
        if ($userRole == $this->appRoles['m']) {
            $checkJob = Job::where('id', $request->jobId)->value('is_rigger');
            if ($checkJob != 1) {
                $files = $request->file('imageFiles');
                $rigger_sign = $request->file('signature');
                $payduty_sign = $request->file('pdSignature');
                if (is_array($files)) {
                    $image_data = [
                        'countPhoto' => count($files),
                        'folderName' => 'rigger-gallery',
                        'imageName' => 'rigger-image'
                    ];
                    // Save Images to folder.
                    $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);
                }
                // Generate a 4-digit random string
                $ticketNumber = mt_rand(1000, 9999);

                // Check if the generated number is unique, if not, regenerate until it is
                while (Rigger::where('ticketNumber', $ticketNumber)->exists()) {
                    $ticketNumber = mt_rand(1000, 9999);
                }

                $add_riggertik = new Rigger();
                $add_riggertik->ticketNumber = $ticketNumber;
                $add_riggertik->specificationsAndRemarks = $request->specificationsAndRemarks ?? '-';
                $add_riggertik->customer = $request->customer;
                $add_riggertik->location = $request->location;
                $add_riggertik->poNumber = $request->poNumber ?? '-';
                $add_riggertik->date = $request->date;
                $add_riggertik->startJob = $request->startJob;
                $add_riggertik->arrivalYard = $request->arrivalYard ?? '--:--';
                $add_riggertik->travelTime = $request->travelTime ?? '-';
                $add_riggertik->totalHours = $request->totalHours;
                $add_riggertik->rating = $request->rating ?? '-';
                $add_riggertik->operation = $request->operator ?? '-';
                $add_riggertik->emailAddress = $request->emailAddress;
                $add_riggertik->notesOthers = $request->notesOthers ?? 'NA';
                $add_riggertik->leaveYard = $request->leaveYard;
                $add_riggertik->finishJob = $request->finishJob;
                $add_riggertik->lunch = $request->lunch ?? '-';
                $add_riggertik->craneTime = $request->craneTime ?? '--:--';
                $add_riggertik->craneNumber = $request->craneNumber ?? '-';
                $add_riggertik->boomLength = $request->boomLength ?? '-';
                $add_riggertik->otherEquipment = $request->otherEquipment ?? 'NA';
                $add_riggertik->isPayDuty = $request->isPayDuty;
                $add_riggertik->job_id = $request->jobId;
                $add_riggertik->account_id = $request->userId;

                $save_ticket = $add_riggertik->save();
                if ($save_ticket) {
                    $signature_data = [
                        'folderName' => 'rigger-signatures',
                        'imageName' => 'rigger-sign',
                        'file_type' => 'signature',
                        'file_ext_type' => 'image',
                        'riggerId' => $add_riggertik->id,
                        'userId' => $add_riggertik->account_id,
                    ];
                    // Save rigger signature to folder.
                    $rigger_signature = Fileupload::singleUploadFile($rigger_sign, $signature_data['riggerId'], $signature_data['folderName'], $signature_data['imageName']);
                    // Save rigger signature to db.
                    $save_signature = Helper::addFile($rigger_signature, $signature_data['file_type'], $signature_data['file_ext_type'], 0, $signature_data['userId'], $signature_data['riggerId'], 0, 0);

                    if ($save_signature['isSave']) {
                        if (is_array($files)) {
                            foreach ($imageFiles as $imageFile) {
                                $add_file = new File();
                                $add_file->file_url = $imageFile;
                                $add_file->base_url = url('') . '/';
                                $add_file->file_type = 'rigger-gallery';
                                $add_file->file_ext_type = 'image';
                                $add_file->job_id = 0;
                                $add_file->account_id = $add_riggertik->account_id;
                                $add_file->rigger_id = $add_riggertik->id;
                                $add_file->transportation_id = 0;
                                $add_file->payduty_id = 0;

                                $add_file->save();
                            }
                        }

                        // Update isRigger field in Job Model to indicate that Rigger Ticket is Attached with the Job.
                        Job::where('id', $add_riggertik->job_id)->update([
                            'is_rigger' => 1
                        ]);

                        if ($request->isPayDuty != 0) {
                            $add_payduty = new Payduty();
                            $add_payduty->date = $request->pdDate;
                            $add_payduty->location = $request->pdLocation;
                            $add_payduty->startTime = $request->pdStartTime;
                            $add_payduty->finishTime = $request->pdFinishTime;
                            $add_payduty->totalHours = $request->pdTotalHours;
                            $add_payduty->officer = $request->pdOfficer;
                            $add_payduty->officerName = $request->pdOfficerName;
                            $add_payduty->division = $request->pdDivision;
                            $add_payduty->email = $request->pdEmailAddress;
                            $add_payduty->account_id = $add_riggertik->account_id;
                            $add_payduty->rigger_id = $add_riggertik->id;

                            $savePayduty = $add_payduty->save();

                            if ($savePayduty) {
                                $payduty_signature_data = [
                                    'folderName' => 'payduty-signatures',
                                    'imageName' => 'payduty-sign',
                                    'file_type' => 'signature',
                                    'file_ext_type' => 'image',
                                    'payduty_id' => $add_payduty->id,
                                    'userId' => $add_riggertik->account_id,
                                ];
                                $payduty_signature = Fileupload::singleUploadFile($payduty_sign, $payduty_signature_data['payduty_id'], $payduty_signature_data['folderName'], $payduty_signature_data['imageName']);
                                // Save rigger signature to db.
                                $save_pd_signature = Helper::addFile($payduty_signature, $payduty_signature_data['file_type'], $payduty_signature_data['file_ext_type'], 0, $payduty_signature_data['userId'], 0, 0, $payduty_signature_data['payduty_id']);
                                if ($save_pd_signature['isSave']) {
                                    $r_data = new RiggerpaydutyResource($add_riggertik);
                                    return response()->json([
                                        'status' => 200,
                                        'message' => 'Rigger ticket submitted with payduty successfully.',
                                        'data' => $r_data
                                    ], 200);
                                }
                            } else {
                                return response()->json([
                                    'status' => 404,
                                    'message' => 'Something went wrong while saving payduty.'
                                ], 404);
                            }
                        }
                        $r_data = new RiggerResource($add_riggertik);
                        return response()->json([
                            'status' => 200,
                            'message' => 'Rigger ticket submitted successfully.',
                            'data' => $r_data
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Something went wrong with the signature.'
                        ], 404);
                    }
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'This job has already a rigger ticket submitted.'
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
