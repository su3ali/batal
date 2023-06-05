<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Category;
use App\Models\Order;
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
        $orders = Order::with('bookings.service.category')
            ->where('user_id', $user->id)
            ->orderBy('id')
            ->get();
        $this->body['orders'] = OrderResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }
    protected function orderDetails($id){
        $user = User::with('orders.status', 'orders.bookings')->where('id', auth('sanctum')->user()->id)->first();
        $order = Order::with('bookings.service.category')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->first();
        $this->body['order'] = OrderResource::make($order);
        return self::apiResponse(200, null, $this->body);
    }
}
