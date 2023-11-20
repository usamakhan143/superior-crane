<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\Auth\LoginRequest;
use App\Http\Resources\AccountResource;
use App\Models\Apis\Auth\Account;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function mobile_sign_in(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $userRole = Account::where('email', $email)->value('role');
        $userStatus = Account::where('email', $email)->value('status');

        if ($userRole == 'manager' || $userRole == 'user') {
            if ($userStatus == 1) {
                $userLogged = Auth::guard('superiorcranes')->attempt([
                    'email' => $email,
                    'password' => $password,
                    'status' => 1
                ]);
                if ($userLogged) {
                    $userdata = Account::where('email', $email)->first();
                    $r_data = new AccountResource($userdata);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Login successfully.',
                        'data' => $r_data
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'Wrong email or password.'
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'You are disabled, contact admins for more information.'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Try login on web app.'
            ], 404);
        }
    }
}
