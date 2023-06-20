<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class PersonalInfoController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function getUserInfo()
    {
        $user = UserResource::make(auth('sanctum')->user());
        $this->body['user'] = $user;
        return self::apiResponse(200, null, $this->body);
    }

    protected function updateUserInfo(Request $request)
    {
        $user = auth('sanctum')->user();
        $user = User::query()->where('id', $user->id)->first();
        $request->validate([
            'name' => 'nullable|min:3|max:100',
            'phone' => 'required|numeric|unique:users,phone,'.$user->id,
            'email' => 'nullable|email|unique:users,email,'.$user->id,
        ]);
        $user->update([
           'first_name' => $request->name,
           'phone' => $request->phone,
           'email' => $request->email
        ]);
        $this->body['user'] = $user;
        return self::apiResponse(200, null, $this->body);
    }
}
