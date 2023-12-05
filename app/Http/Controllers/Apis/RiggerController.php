<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\AddriggerticketRequest;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\File;
use App\Models\Apis\Job;
use App\Models\Apis\Payduty;
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
                $rigger_sign = $request->file('signature');
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
                        'imageName' => 'rigger-sign'
                    ];
                    // Save rigger signature to folder.
                    $rigger_signature = Fileupload::singleUploadFile($rigger_sign, $add_riggertik->id, $signature_data['folderName'], $signature_data['imageName']);
                    // Save rigger signature to db.
                    $add_signature = new File();
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

                    if ($request->isPayDuty != 0) {
                        $add_payduty = new Payduty();
                        $add_payduty->date = $request->date;
                        $add_payduty->location = $request->location;
                        $add_payduty->startTime = $request->startTime;
                        $add_payduty->finishTime = $request->finishTime;
                        $add_payduty->totalHours = $request->totalHours;
                        $add_payduty->officer = $request->officer;
                        $add_payduty->officerName = $request->officerName;
                        $add_payduty->division = $request->division;
                        $add_payduty->email = $request->emailAddress;
                        $add_payduty->account_id = $request->userId;
                        $add_payduty->rigger_id = $add_riggertik->id;
                    }

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
