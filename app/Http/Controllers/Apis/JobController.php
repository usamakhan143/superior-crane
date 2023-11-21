<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\AddjobRequest;

class JobController extends Controller
{
    // Create Job
    public function create_job(AddjobRequest $request)
    {
        return response()->json($request->all());
    }
}
