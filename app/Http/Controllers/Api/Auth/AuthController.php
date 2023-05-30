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
use App\Traits\SMSTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MoemenGaballah\Msegat\Msegat;

class AuthController extends Controller
{
    use ApiResponse, SMSTrait;

    public function __construct()
    {
        $this->middleware('localize');
    }

    /**
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $user = User::query()->where('phone', $request->phone)->first();



        if (!$user) {
            $validated = $request->validate([
                'phone' => 'required|numeric|unique:users,phone'
            ], $request->all());
            $user = User::query()->create([
                'phone' => $validated['phone'],
                'city_id' => 0,
            ]);
        }else{
            $validated = $request->validate([
                'phone' => 'required|numeric|unique:users,phone,'.$user->id
            ], $request->all());
        }
        $code = random_int(1000, 9999);
        $user->update([
            'code' => $code
        ]);
        $m = "رمز التحقق: ".$code;
        $msg = $this->sendMessage($validated['phone'], $m);
        $this->message = t_('login successfully, but code is needed');
        $this->body['user'] = UserResource::make($user);
        return self::apiResponse(200, $this->message, $this->body);
    }

    public function verify(Request $request)
    {
        $user = User::query()->where('id', $request->user_id)->first();
        if ($request->code == $user->code && $user) {
                $user->update([
                    'code' => null,
                    'fcm_token' => $request->fcm_token
                ]);
                Auth::loginUsingId($user->id);
                $this->message = t_('login successfully');
                $this->body['user'] = UserResource::make($user);
                $this->body['accessToken'] = $user->createToken('user-token',['user'])->plainTextToken;
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
