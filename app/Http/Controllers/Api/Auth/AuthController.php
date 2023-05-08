<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ProfileUpdateRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Sms\HiSms;
use App\Support\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    public function login(Request $request)
    {
        $validated = $request->all();
        $cred = ['phone' => $validated['phone']];

        if (\auth()->attempt($cred)) {
            $user = Auth::user();
            $this->message = t_('login successfully');
            $this->body['user'] = UserResource::make($user);
            return self::apiResponse(200, $this->message, $this->body);

        } else {

            $this->message = t_('auth failed');
            return self::apiResponse(400, $this->message, $this->body);
        }

    }

    public function verify(Request $request){
        if ($request->code == 111111){
            $user = User::query()->where('id', $request->id)->first();
            $this->body['user'] = UserResource::make($user);
            $this->body['accessToken'] = $user->createToken('user-token')->plainTextToken;
            return self::apiResponse(200, $this->message, $this->body);
        }
        $this->message = t_('auth failed');
            return self::apiResponse(400, $this->message, $this->body);
    }

    public function logout(Request $request)
    {
        auth()->user('sanctum')->tokens()->delete();
        $this->message = t_('Logged out');

        return self::apiResponse(200, $this->message, $this->body);

    }
}
