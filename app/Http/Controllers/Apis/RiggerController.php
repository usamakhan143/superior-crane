<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\AddriggerticketRequest;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\Job;
use App\Models\Apis\Rigger;

class RiggerController extends Controller
{
    private $appRoles;

    public function __construct()
    {
        $this->appRoles = Helper::getRoles();
    }

    public function create_ticket(AddriggerticketRequest $request)
    {
        $userRole = Account::where('id', $request->userId)->value('role');
        if ($userRole == $this->appRoles['m']) {
            $checkJob = Job::where('id', $request->jobId)->value('is_rigger');
            if ($checkJob != 1) {
                $files = $request->file('imageFiles');
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
                $add_riggertik->specificationsAndRemarks = $request->specificationsAndRemarks;
                $add_riggertik->customer = $request->customer;
                $add_riggertik->location = $request->location;
                $add_riggertik->poNumber = $request->poNumber;
                $add_riggertik->date = $request->date;
                $add_riggertik->startJob = $request->startJob;
                $add_riggertik->arrivalYard = $request->arrivalYard;
                $add_riggertik->travelTime = $request->travelTime;
                $add_riggertik->totalHours = $request->totalHours;
                $add_riggertik->rating = $request->rating;
                $add_riggertik->operation = $request->operator;
                $add_riggertik->emailAddress = $request->emailAddress;
                $add_riggertik->notesOthers = $request->notesOthers;
                $add_riggertik->leaveYard = $request->leaveYard;
                $add_riggertik->finishJob = $request->finishJob;
                $add_riggertik->lunch = $request->lunch;
                $add_riggertik->craneTime = $request->craneTime;
                $add_riggertik->craneNumber = $request->craneNumber;
                $add_riggertik->boomLength = $request->boomLength;
                $add_riggertik->otherEquipment = $request->otherEquipment;
                $add_riggertik->isPayDuty = $request->isPayDuty;
                $add_riggertik->job_id = $request->jobId;
                $add_riggertik->account_id = $request->userId;
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
