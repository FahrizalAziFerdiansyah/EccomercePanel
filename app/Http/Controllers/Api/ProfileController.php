<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        $profile = Profile::where('user_id', $request->user_id)->first();
        $user = Auth::user();
        $merge = collect($profile)->merge($user);
        return response([
            'success' => true,
            'data' => $merge
        ], 201);
    }
    public function store(Request $request)
    {

        $values = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
        ]);
        $user = User::find($request->user_id);
        $profile = Profile::where('user_id', $request->user_id)->first();
        if ($profile) {
            $user->update($request->only('name', 'phone'));
            $profile->update($request->only('date_of_birth', 'gender'));
        } else {
            $profile = Profile::create($request->only('user_id', 'date_of_birth', 'gender'));
        }
        return response([
            'success' => true,
            'data' => collect($profile)->merge($user)
        ], 201);
    }
    public function address(Request $request)
    {
        $address = Address::where('user_id', $request->user_id)->get();
        return response([
            'success' => true,
            'data' => $address
        ], 201);
    }
    public function createAddress(Request $request)
    {
        $values = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'type' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);
        $values['is_selected'] = 0;
        $address = Address::create($values);
        return response([
            'success' => true,
            'data' => $address
        ], 201);
    }
    public function updateAddress(Request $request)
    {
        $values = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'type' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);
        $address = Address::where('id', $request->id)->first();
        $address->update($values);
        return response([
            'success' => true,
            'data' => $address
        ], 201);
    }

    public function setAddress(Request $request)
    {
        $address = Address::where('user_id', $request->user_id)->where('is_selected', 1)->first();
        if (!empty($address)) {
            $address->update(['is_selected' => 0]);
        }
        $set_address = Address::find($request->id);
        $set_address->update(['is_selected' => 1]);
        $addresses = Address::where('user_id', $request->user_id)->get();
        return response([
            'success' => true,
            'data' => $addresses
        ], 201);
    }

    public function deleteAddress(Request $request)
    {
        $address = Address::find($request->id);
        $address->delete();
        return response([
            'success' => true,
            'data' => $address
        ], 201);
    }
}
