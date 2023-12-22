<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\Auth\AccountRequest;
use App\Http\Requests\Apis\Auth\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use Illuminate\Support\Str;
use App\Models\Apis\Auth\Account;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Create User
    public function create_user(AccountRequest $request)
    {
        $username = $this->generateUniqueUsername($request->name);
        $data = [
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'username' => $username,
            'status' => 1
        ];

        $add_user = new Account();

        $add_user->name = $data['name'];
        $add_user->email = $data['email'];
        $add_user->password = $data['password'];
        $add_user->username = $data['username'];
        $add_user->role = $data['role'];
        $add_user->status = $data['status'];

        $save_user = $add_user->save();

        if ($save_user) {
            $r_data = new AccountResource($add_user);
            return response()->json([
                'status' => 200,
                'message' => 'Registration successfull.',
                'data' => $r_data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong.'
            ], 404);
        }
    }


    // Update User
    public function update_user(UpdateAccountRequest $request, $id)
    {
        $edit_user = Account::find($id);
        if ($edit_user !== null) {
            if (!empty($request->all())) {
                $data = [
                    'role' => $request->role ?? $edit_user->role,
                    'email' => $edit_user->email,
                    'password' => Hash::make($request->password) ?? $edit_user->password,
                    'name' => $request->name ?? $edit_user->name,
                    'username' => $edit_user->username,
                    'status' => $request->status ?? $edit_user->status
                ];


                $edit_user->name = $data['name'];
                $edit_user->email = $data['email'];
                $edit_user->password = $data['password'];
                $edit_user->username = $data['username'];
                $edit_user->role = $data['role'];
                $edit_user->status = $data['status'];

                $update_user = $edit_user->update();

                if ($update_user) {
                    $r_data = new AccountResource($edit_user);
                    return response()->json([
                        'status' => 200,
                        'message' => 'User updated successfully.',
                        'data' => $r_data
                    ]);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Something went wrong.'
                    ], 404);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No data requested to update.'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Userid doesnot exist.'
            ], 404);
        }
    }


    // Delete User
    public function delete_user($id)
    {
        $del = Account::find($id);
        if ($del !== null) {
            $del_user = $del->delete();
            if ($del_user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Registration deleted successfully.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Userid doesnot exist.'
            ], 404);
        }
    }


    private function generateUniqueUsername($name)
    {
        // Convert name to lowercase and remove spaces
        $cleanedName = strtolower(str_replace(' ', '', $name));

        // Generate a unique username using the name and a random string
        $uniqueUsername = $cleanedName . '_' . Str::random(3);

        // Check if the generated username is unique
        while (Account::where('username', $uniqueUsername)->exists()) {
            $uniqueUsername = $cleanedName . '_' . Str::random(3);
        }

        return $uniqueUsername;
    }
}
