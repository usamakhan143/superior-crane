<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\TransportationRequest;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function create_transportation(TransportationRequest $request) {
        return response()->json();
    }
}
