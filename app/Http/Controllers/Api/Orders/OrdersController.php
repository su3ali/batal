<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Order;
use App\Models\RateTechnician;
use App\Models\Technician;
use App\Models\User;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
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
    protected function rateTechnicians(Request $request){
        $rules = [
            'group_id' => 'required|exists:groups,id',
            'booking_id' => 'required|exists:bookings,id',
            'rate' => 'required|integer',
            'note' => 'nullable|string|max:255',
        ];
        $request->validate($rules, $request->all());
        $technicians = Technician::query()->where('group_id', $request->group_id)->get();
        $order_id = Booking::query()->find($request->booking_id)->order_id;
        foreach ($technicians as $technician){
            RateTechnician::query()->create([
               'user_id' => auth()->user()->id,
               'technician_id' => $technician->id,
               'order_id' => $order_id,
               'rate' => $request->rate,
               'note' => $request->note,
            ]);
        }
        return self::apiResponse(200, 'rated successfully', $this->body);

    }
}
