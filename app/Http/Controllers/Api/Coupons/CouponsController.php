<?php

namespace App\Http\Controllers\Api\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Coupons\CouponsResource;
use App\Models\Coupon;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function allCoupons(){
        $coupons = Coupon::query()->where('active', 1)
            ->where('start', '<=', Carbon::now())->where('end', '>=', Carbon::now())
            ->get();
        $this->body['coupons'] = CouponsResource::collection($coupons);
        return self::apiResponse(200, null, $this->body);
    }
}
