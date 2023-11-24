<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\AddjobRequest;
use App\Http\Requests\Apis\UpdatejobRequest;
use App\Http\Resources\Jobs\AddResource;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\File;
use App\Models\Apis\Job;

class JobController extends Controller
{
    private $appRoles;

    public function __construct()
    {
        $this->appRoles = Helper::getRoles();
    }

    // Create Job
    public function create_job(AddjobRequest $request)
    {
        $userRole = Account::where('id', $request->userId)->value('role');
        if ($userRole == $this->appRoles['a'] || $userRole == $this->appRoles['sa']) {
            $files = $request->file('imageFiles');
            if (is_array($files)) {
                $image_data = [
                    'countPhoto' => count($files),
                    'folderName' => 'job-gallery',
                    'imageName' => 'job-image'
                ];
                // Save Images to folder.
                $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);
            }
            // Generate a 4-digit random string
            $jobNumber = mt_rand(1000, 9999);

            // Check if the generated number is unique, if not, regenerate until it is
            while (Job::where('job_number', $jobNumber)->exists()) {
                $jobNumber = mt_rand(1000, 9999);
            }

            // Now $jobNumber contains a unique 4-digit number that can be used as a job number

            $add_job = new Job();
            $add_job->client_name = $request->clientName;
            $add_job->job_number = $jobNumber;
            $add_job->job_date = $request->jobDate;
            $add_job->job_time = $request->jobTime;
            $add_job->address = $request->address;
            $add_job->equipment_used = $request->equipmentToBeUsed;
            $add_job->rigger_assigned = $request->riggerAssigned;
            $add_job->supplier_name = $request->supplierName;
            $add_job->enter_by = $request->enterBy;
            $add_job->status_code = 'goodTogo';
            $add_job->notes = $request->notes;
            $add_job->is_scci = $request->isSCCI;
            $add_job->account_id = $request->userId;
            $add_job->is_rigger = false;
            $add_job->is_transportation = false;
            $add_job->pdf_rigger = 'NA';
            $add_job->pdf_transportation = 'NA';

            $save_job = $add_job->save();

            if ($save_job) {
                if (is_array($files)) {
                    foreach ($imageFiles as $imageFile) {
                        $add_file = new File();
                        $add_file->file_url = $imageFile;
                        $add_file->base_url = url('') . '/';
                        $add_file->file_type = 'job-gallery';
                        $add_file->file_ext_type = 'image';
                        $add_file->job_id = $add_job->id;
                        $add_file->account_id = $add_job->account_id;
                        $add_file->rigger_id = 0;
                        $add_file->transportation_id = 0;
                        $add_file->payduty_id = 0;

                        $add_file->save();
                    }
                }
                $r_data = new AddResource($add_job);
                return response()->json([
                    'status' => 200,
                    'message' => 'Job added successfully.',
                    'data' => $r_data,
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized for this action.'
            ], 401);
        }
    }


    // Update Job
    public function update_job(UpdatejobRequest $request, $id) {
        
        $edit_job = Job::find($id);
        return response()->json($request->all());
        $files = $request->file('imageFiles');
        if(is_array($files)) {
            $image_data = [
                'countPhoto' => count($files),
                'folderName' => 'job-gallery',
                'imageName' => 'job-image'
            ];
            // Save Images to folder.
            $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);
        }

        $edit_job->client_name = $request->clientName ?? $edit_job->client_name;
        $edit_job->job_number = $edit_job->job_number;
        $edit_job->job_date = $request->jobDate ?? $edit_job->job_date;
        $edit_job->job_time = $request->jobTime ?? $edit_job->job_time;
        $edit_job->address = $request->address ?? $edit_job->address;
        $edit_job->equipment_used = $request->equipmentToBeUsed ?? $edit_job->equipment_used;
        $edit_job->rigger_assigned = $request->riggerAssigned ?? $edit_job->rigger_assigned;
        $edit_job->supplier_name = $request->supplierName ?? $edit_job->supplier_name;
        $edit_job->enter_by = $request->enterBy ?? $edit_job->enter_by;
        $edit_job->status_code = $request->statusCode ?? $edit_job->status_code;
        $edit_job->notes = $request->notes ?? $edit_job->notes;
        $edit_job->is_scci = $request->isSCCI ?? $edit_job->is_scci;
        $edit_job->account_id = $edit_job->account_id;
        $edit_job->is_rigger = $edit_job->is_rigger;
        $edit_job->is_transportation = $edit_job->is_transportation;
        $edit_job->pdf_rigger = $edit_job->pdf_rigger;
        $edit_job->pdf_transportation = $edit_job->pdf_rigger;

        $update_job = $edit_job->update();

        if ($update_job) {

            if(is_array($files)) {
                foreach ($imageFiles as $imageFile) {
                    $add_file = new File();
                    $add_file->file_url = $imageFile;
                    $add_file->base_url = url('') . '/';
                    $add_file->file_type = 'job-gallery';
                    $add_file->file_ext_type = 'image';
                    $add_file->job_id = $edit_job->id;
                    $add_file->account_id = $edit_job->account_id;
                    $add_file->rigger_id = 0;
                    $add_file->transportation_id = 0;
                    $add_file->payduty_id = 0;

                    $add_file->save();
                }
            }

            $r_data = new AddResource($edit_job);
            return response()->json([
                'status' => 200,
                'message' => 'Job updated successfully.',
                'data' => $r_data,
            ]);
        }

    }
}
