<?php

namespace App\Http\Controllers\Api\Techn\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Technician\auth\TechnicianResource;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    /**
     * @throws \Exception
     */
    public function login(Request $request)
    {

        $validated = $request->validate([
            'user_name' => 'required',
            'password' => ['required', Password::min(4)],
        ], $request->all());

        $cred = ['user_name' => $validated['user_name'], 'password' => $validated['password']];

        if (Auth::guard('technician')->attempt($cred)) {

            $techn = Auth::guard('technician')->user();
            $techn->update([
                'fcm_token' => $request->fcm_token
            ]);
            $this->message = __('api.login successfully');
            $this->body['technician'] = TechnicianResource::make($techn);
            $this->body['accessToken'] = $techn->createToken('technician-token', ['technician'])->plainTextToken;
            return self::apiResponse(200, $this->message, $this->body);
        } else {
            $this->message = __('api.auth failed');
            return self::apiResponse(400, $this->message, $this->body);
        }
    }


    public function logout(Request $request)
    {
        auth()->user('sanctum')->tokens()->delete();
        auth()->user()->update([
            'fcm_token' => null
        ]);
        $this->message = __('api.Logged out');

        return self::apiResponse(200, $this->message, $this->body);
    }

    public function deleteAccount(Request $request)
    {
        $user =  auth('sanctum')->user();
        $user->delete();
        $this->message = __('api.Delete technician successfully');

        return self::apiResponse(200, $this->message, $this->body);
    }
}
