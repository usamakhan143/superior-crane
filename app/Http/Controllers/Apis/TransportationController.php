<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\TransportationRequest;

class TransportationController extends Controller
{
    public function createTicket(TransportationRequest $request) {
        return response()->json([
            'status' => 200,
            'message' => 'Ticket submitted successfully.',
            'data' => $request->all()
        ]);
    }
}
