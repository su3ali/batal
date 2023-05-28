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
        $this->middleware('localize');
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
            $this->message = t_('login successfully, but code is needed');
            $this->body['technician'] = TechnicianResource::make($techn);
            $this->body['accessToken'] = $techn->createToken('technician-token')->plainTextToken;
            return self::apiResponse(200, $this->message, $this->body);
        }else{
            $this->message = t_('auth failed');
            return self::apiResponse(400, $this->message, $this->body);
        }

    }


        public function logout(Request $request)
        {
            auth()->user('sanctum')->tokens()->delete();
            $this->message = t_('Logged out');

            return self::apiResponse(200, $this->message, $this->body);

        }
    }