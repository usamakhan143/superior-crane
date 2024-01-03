<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\JobfilterRequest;
use App\Http\Requests\Apis\RiggerfilterRequest;
use App\Http\Resources\Jobs\GetjobResource;
use App\Http\Resources\Rigger\RiggerResource;
use App\Models\Apis\Job;
use App\Models\Apis\Rigger;

class FilterController extends Controller
{
    // Job Filter
    public function JobFilter(JobfilterRequest $request) {
    
        // Get the query parameters
        $clientName = $request->input('clientName');
        $address = $request->input('address');
        $jobDate = $request->input('jobDate');

        // Initialize the query
        $query = Job::query();

        // Apply filters based on the request parameters
        if ($clientName) {
            $query->where('client_name', '=', $clientName);
        }

        if ($address) {
            $query->orwhere('address', '=', $address);
        }

        if ($jobDate) {
            $query->orwhere('job_date', '=', $jobDate);
        }

        // Fetch the records
        $jobs = $query->get();
        $jobResources = GetjobResource::collection($jobs);

        return response()->json($jobResources);
    }

    // Rigger Filter
    public function riggerFilter(RiggerfilterRequest $request) {

        // Get the query parameters
        $customer = $request->input('customer');
        $location = $request->input('location');
        $date = $request->input('date');

        // Initialize the query
        $query = Rigger::query();

        // Apply filters based on the request parameters
        if ($customer) {
            $query->where('customer', '=', $customer);
        }

        if ($location) {
            $query->orwhere('location', '=', $location);
        }

        if ($date) {
            $query->orwhere('date', '=', $date);
        }

        // Fetch the records
        $riggers = $query->get();
        $riggerResources = RiggerResource::collection($riggers);

        return response()->json($riggerResources);

    }
}
