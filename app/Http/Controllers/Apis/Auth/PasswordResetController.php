<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\Auth\SendotpRequest;
use App\Http\Requests\Apis\Auth\UpdatepasswordRequest;
use App\Http\Requests\Apis\Auth\VerifyotpRequest;
use App\Http\Resources\SendotpResource;
use App\Mail\SendOtp;
use App\Models\Apis\Auth\Account;
use App\Models\Apis\Auth\Forgotpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{

    // Send OTP
    public function sendOtp(SendotpRequest $request)
    {
        $accounts = Account::where('email', $request->email)->first();

        // Delete any existing password reset records for this email
        Forgotpassword::where('email', $request->email)->delete();

        $otp = rand(1000, 9999); // Generate a 6-digit OTP
        $token = Str::random(60);
        // Save the OTP in the password reset table
        $saveotp = Forgotpassword::create([
            'email' => $request->email,
            'otp' => $otp,
            'token' => $token,
        ]);

        if ($saveotp) {
            // Send the OTP to the accounts (You need to implement your notification logic here)    
            Mail::to($request->email)->send(new SendOtp($otp));
            $r_data = new SendotpResource($saveotp);
            return response()->json([
                'status' => 200,
                'message' => 'OTP sent successfully',
                'data' => $r_data
            ]);
        }
    }




    // Verify OTP
    public function verifyOtp(VerifyotpRequest $request)
    {

        $Forgotpassword = Forgotpassword::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$Forgotpassword) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid OTP'
            ], 400);
        }

        // You may add additional validation if needed before proceeding

        return response()->json([
            'status' => 200,
            'message' => 'OTP verified successfully'
        ]);
    }




    // Update Password
    public function updatePassword(UpdatepasswordRequest $request)
    {
        $passwordReset = Forgotpassword::where('email', $request->email)->first();

        if (!$passwordReset) {
            return response()->json([
                'status' => 400,
                'message' => 'OTP is expired'
            ], 400);
        }

        // Update user password
        $userid = Account::where('email', $request->email)->value('id');
        $user = Account::find($userid);
        $user->password = Hash::make($request->password);
        $updatePass = $user->update();

        if ($updatePass) {
            // Delete the password reset record
            $passwordReset->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Password updated successfully'
            ]);
        }
    }
}
