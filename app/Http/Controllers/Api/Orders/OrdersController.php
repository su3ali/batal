<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\RateService;
use App\Models\RateTechnician;
use App\Models\Technician;
use App\Models\User;
use App\Models\Visit;
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
            ->orderBy('id','DESC')
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
            'visit_id' => 'required|exists:visits,id',
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
                'visit_id' => $request->visit_id,
               'order_id' => $order_id,
               'rate' => $request->rate,
               'note' => $request->note,
            ]);
        }
        return self::apiResponse(200, __('api.rated successfully'), $this->body);

    }


    protected function rateService(Request $request){
        $rules = [
            'visit_id' => 'required|exists:visits,id',
            'rate' => 'required|integer',
            'note' => 'nullable|string|max:255',
        ];
        $request->validate($rules, $request->all());

        $visit = Visit::where('id',$request->visit_id)->first();
        $booking = Booking::where('id',$visit->booking_id)->first();

            RateService::query()->create([
                'user_id' => auth()->user()->id,
                'service_id' => null,
                'visit_id' => $request->visit_id,
                'order_id' => $booking->order_id,
                'rate' => $request->rate,
                'note' => $request->note,
            ]);

        return self::apiResponse(200, __('api.rated successfully'), $this->body);

    }
}
