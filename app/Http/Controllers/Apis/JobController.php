<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\AddjobRequest;
use App\Http\Resources\Jobs\AddResource;

class JobController extends Controller
{
    // Create Job
    public function create_job(AddjobRequest $request)
    {
        $files = $request->file('imageFiles');
        $image_data = [
            'countPhoto' => count($files),
            'folderName' => 'job-gallery',
            'imageName' => 'job-image'
        ];
        $imageFiles = Fileupload::multiUploadFile($files, $image_data['countPhoto'], $image_data['folderName'], $image_data['imageName']);
        $r_data = new AddResource($request->all());
        return response()->json([
            'data' => $r_data,
            'images' => $imageFiles
        ]);
    }
}
