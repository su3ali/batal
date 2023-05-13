<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\User;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function myOrders(){
        $user = User::with('orders.status', 'orders.bookings')->where('id', auth('sanctum')->user()->id)->first();
        $this->body['orders'] = OrderResource::collection($user->orders);
        return self::apiResponse(200, null, $this->body);
    }
}
