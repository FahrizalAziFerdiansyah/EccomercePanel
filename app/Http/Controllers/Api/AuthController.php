<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (empty($user)) {
            return response([
                'success'   => false,
                'errors' => ['phone' => 'phone not regiester']
            ], 404);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'success'   => false,
                'errors' => ['password' => 'password invalid']
            ], 404);
        }

        $token = $user->createToken('ApiToken')->plainTextToken;
        $response = [
            'success'   => true,
            'user'      => $user,
            'token'     => $token
        ];
        return response($response, 201);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
        ]);
        $user = User::find($request->user_id)->first();
        if (!Hash::check($request->current_password, $user->password)) {
            return response([
                'success'   => false,
                'errors' => ['current_password' => 'current password invalid']
            ], 404);
        } else {
            $user->update(['password' => bcrypt($request->new_password)]);
            return response([
                'success' => true,
                'message' => "Success change password"
            ], 201);
        }
    }
    public function register(Request $request)
    {
        $values = $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
            'phone' => 'required|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        $values['password'] = bcrypt($values['password']);
        $user = User::create($values);
        return response([
            'success' => true,
            'message' => "Success registration"
        ], 201);
    }
}
