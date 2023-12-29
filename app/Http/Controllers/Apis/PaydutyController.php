<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payduty\PaydutyResource;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\Payduty;
use Illuminate\Http\Request;

class PaydutyController extends Controller
{
    private $appRoles;

    public function __construct()
    {
        $this->appRoles = Helper::getRoles();
    }

    public function getPayDuty($id = null, Request $request) {
        if ($id != null) {
            $userRole = Account::where('id', $id)->value('role');
            if ($userRole == $this->appRoles['sa'] || $userRole == $this->appRoles['a']) {

                // Get the query params.
                $queryParams = $request->all();
                $query = Payduty::query();

                // Apply filters based on all query parameters
                foreach ($queryParams as $field => $value) {
                    // Skip non-filterable parameters, adjust as needed
                    if (!in_array($field, ['date', 'location', 'id', 'totalHours', 'officer', 'officerName', 'division', 'email', 'riggerId', 'userId'])) {
                        continue;
                    }

                    // Map 'userId' to 'account_id' if the field is 'userId'
                    if ($field === 'userId') {
                        $field = 'account_id';
                    }
                    // Map 'riggerId' to 'rigger_id' if the field is 'jobId'
                    if ($field === 'riggerId') {
                        $field = 'rigger_id';
                    }

                    // Apply condition to the query
                    $query->where($field, '=', $value);
                }

                // Fetch the records
                $payDuties = $query->get();
                $r_data = PaydutyResource::collection($payDuties);
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
}
