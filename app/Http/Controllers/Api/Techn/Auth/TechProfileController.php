<?php

namespace App\Http\Controllers\Api\Techn\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Technician\auth\TechnicianResource;
use App\Http\Resources\User\UserResource;
use App\Models\Technician;
use App\Models\User;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class TechProfileController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function getTechnInfo()
    {
        $techn = TechnicianResource::make(auth('sanctum')->user());
        $this->body['techn'] = $techn;
        return self::apiResponse(200, null, $this->body);
    }

    protected function updateTechnInfo(Request $request)
    {
        $techn = auth('sanctum')->user();
        $techn = Technician::query()->where('id', $techn->id)->first();
        $request->validate([
            'name' => 'nullable|min:3|max:100',
            'phone' => 'required|numeric|unique:users,phone,'.$techn->id,
            'email' => 'nullable|email|unique:users,email,'.$techn->id,
        ]);
        $techn->update([
           'name' => $request->name,
           'phone' => $request->phone,
           'email' => $request->email
        ]);
        $this->body['techn'] = $techn;
        return self::apiResponse(200, null, $this->body);
    }
}
