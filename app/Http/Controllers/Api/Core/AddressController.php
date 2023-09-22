<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function getAddresses()
    {
        $addresses = UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->get();
        $this->body['addresses'] = UserAddressResource::collection($addresses);
        return self::apiResponse(200, null, $this->body);
    }

    protected function addAddress(Request $request)
    {
        $request->validate([
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'region_id' => 'nullable|exists:regions,id',
            'address' => 'required|string|max:300',
            'name' => 'required|string|max:300',
            'active' => 'nullable|in:on,off',
            'is_default' => 'required|in:yes,no',
            'lat' => 'nullable|Numeric',
            'long' => 'nullable|Numeric',
            'phone' => 'nullable|Numeric',
        ]);
        $data = $request->except('_token', 'active', 'is_default');

        if ($request['active'] && $request['active'] == 'on') {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
        }
        if ($request['is_default'] && $request['is_default'] == 'no') {
            $data['is_default'] = 0;
        } else {
            UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->update([
                'is_default' => 0
            ]);
            $data['is_default'] = 1;
        }
        $data['user_id'] = auth('sanctum')->user()->id;
        UserAddresses::query()->create($data);

        $addresses = UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->get();
        $this->body['addresses'] = UserAddressResource::collection($addresses);
        return self::apiResponse(200, null, $this->body);

    }

    protected function updateAddress(Request $request, $id)
    {
        $address = UserAddresses::find($id);
        if ($address) {
            $request->validate([
                'country_id' => 'nullable|exists:countries,id',
                'city_id' => 'nullable|exists:cities,id',
                'region_id' => 'nullable|exists:regions,id',
                'address' => 'required|string|max:300',
                'name' => 'required|string|max:300',
                'active' => 'nullable|in:on,off',
                'is_default' => 'required|in:yes,no',
                'lat' => 'nullable|Numeric',
                'long' => 'nullable|Numeric',
                'phone' => 'nullable|Numeric',
            ]);
            $data = $request->except('_token', 'active', 'is_default');

            if ($request['active'] && $request['active'] == 'on') {
                $data['active'] = 1;
            } else {
                $data['active'] = 0;
            }

            if ($request['is_default'] && $request['is_default'] == 'no') {
                $data['is_default'] = 0;
            } else {
                UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->update([
                    'is_default' => 0
                ]);
                $data['is_default'] = 1;
            }
            $data['user_id'] = auth('sanctum')->user()->id;

            $address->update($data);
            $addresses = UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->get();
            $this->body['addresses'] = UserAddressResource::collection($addresses);
            return self::apiResponse(200, null, $this->body);
        } else {
            return self::apiResponse(400, __('api.not found'), $this->body);
        }

    }

    protected function deleteAddress($id)
    {
        $address = UserAddresses::find($id);
        if ($address) {
            $address->delete();
            $addresses = UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->get();
            $this->body['addresses'] = UserAddressResource::collection($addresses);
            return self::apiResponse(200, null, $this->body);        } else {
            return self::apiResponse(200, __('api.not found or already deleted'), $this->body);
        }

    }

    protected function makeAddressDefault($id)
    {
        $address = UserAddresses::query()->where('id', $id)->first();
        if ($address) {
            UserAddresses::query()->where('id', '!=', $id)->update([
                'is_default' => 0
            ]);
            $address->update([
                'is_default' => 1
            ]);
            return self::apiResponse(200, __('api.been default successfully'), $this->body);
        } else {
            return self::apiResponse(400, __('api.not found'), $this->body);
        }

    }
}
