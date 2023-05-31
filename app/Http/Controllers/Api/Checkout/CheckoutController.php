<?php

namespace App\Http\Controllers\Api\Checkout;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Transaction;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class CheckoutController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function checkout(Request $request)
    {
        $rules = [
            'user_address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|in:cache,visa',
            'coupon' => 'nullable|numeric',
        ];
        $request->validate($rules, $request->all());
        $user = auth()->user('sanctum');
        $carts = Cart::query()->where('user_id', $user->id)->get();
        if (!$carts->first()) {
            return self::apiResponse(400, t_('Cart is empty'), []);
        }
        $total = $this->calc_total($carts);
        return $this->saveOrder($user, $request, $total, $carts);
    }

    private function calc_total($carts)
    {
        $total = [];
        for ($i = 0; $i < $carts->count(); $i++) {
            $cart_total = ($carts[$i]->price) * $carts[$i]->quantity;
            $total[] = $cart_total;
        }
        return array_sum($total);
    }

    private function saveOrder($user, $request, $total, $carts)
    {
        $order = Order::create([
            'user_id' => $user->id,
            'discount' => $request->coupon,
            'user_address_id' => $request->user_address_id,
            'sub_total' => $total,
            'total' => ($total - $request->coupon),
            'payment_method' => $request->payment_method,
            'status_id' => 3,
        ]);
        foreach ($carts as $cart) {
            OrderService::create([
                'order_id' => $order->id,
                'service_id' => $cart->service_id,
                'price' => $cart->price,
                'quantity' => $cart->quantity,
            ]);
            $service = Service::query()->find($cart->service_id);
            $service?->save();

            $last = Booking::query()->latest()->first()?->id;
            $booking_no = 'dash2023/' . $last ? $last + 1 : 1;
            Booking::query()->create([
                'booking_no' => $booking_no,
                'user_id' => auth('sanctum')->user()->id,
                'service_id' => $cart->service_id,
                'order_id' => $order->id,
                'user_address_id' => $order->user_address_id,
                'booking_status_id' => 1,
                'notes' => $cart->notes,
                'quantity' => $cart->quantity,
                'date' => $cart->date,
                'type' => 'service',
                'time' => Carbon::createFromTimestamp($cart->time)->toTimeString(),
            ]);
        }
//        if ($request->payment_type != 1) {
//            $address = $user_address->address;
//            $city = $user_address->shipping->area->title;
//            $country = Area::query()->find($user_address->shipping->area->parent_id)?->title;
//            $total = $total + $order->shipping?->price;
//            $payment = new Payment($total, $user, $order, $address, $city, $country);
//            return $payment->payment();
//        }
        if ($request->payment_method == 'cache') {
            $transaction = Transaction::create([
                'order_id' => $order->id,
                'transaction_number' => 'cache/'.rand(1111111111, 9999999999),
                'payment_result' => 'success',
            ]);
            Cart::query()->whereIn('id', $carts->pluck('id'))->delete();
            $order->status_id = 4;
            $order->save();
            $this->body['order_id'] = $order->id;
            return self::apiResponse(200, t_('order created successfully'), $this->body);
        }
    }


    public function callbackPayment(Request $request)
    {
        $result = app(Paypage::class)->queryTransaction($request->tranRef);
        $order = Order::findOrFail($request->order_id);

        if ($result->success) {
            $carts = Cart::where('user_id', $order->user_id)->get();
            foreach ($carts as $cart) {
                $service = $cart->service;
                $service->stock = $cart->service->stock - $cart->quantity;
                $service->save();
            }
            Cart::query()->whereIn('id', $carts->pluck('id'))->delete();

            Transaction::create([
                'order_id' => $request->order_id,
                'transaction_number' => $result->transaction_id,
                'payment_result' => 'success',
            ]);
            $order->status = 'paid';
            $order->save();

            $image = 'dashboard/img/media/success.png';
        } else {
            Transaction::create([
                'order_id' => $request->order_id,
                'transaction_number' => $result->transaction_id,
                'payment_result' => 'fail',
            ]);
            $image = 'dashboard/img/media/error.jpg';
        }
        return view('frontend.payment_back', compact('image'));
    }
}
