<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\Auth\AccountRequest;
use App\Http\Resources\AccountResource;
use Illuminate\Support\Str;
use App\Models\Apis\Auth\Account;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
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
                'message' => 'User added successfully.',
                'data' => $r_data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong.'
            ]);
        }
    }



    public function update_user(AccountRequest $request, $id)
    {
        $data = [
            'role' => $request->role,
            'password' => $request->password,
            'name' => $request->name,
            'status' => 1
        ];

        $edit_user = Account::find($id);

        $edit_user->name = $data['name'];
        $edit_user->password = $data['password'];
        $edit_user->role = $data['role'];
        $edit_user->status = $data['status'];

        $update_user = $edit_user->update();

        if ($update_user) {

            return response()->json([
                'status' => 200,
                'message' => 'User updated successfully.',
                'data' => $edit_user
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'data' => 'Something went wrong.'
            ]);
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
