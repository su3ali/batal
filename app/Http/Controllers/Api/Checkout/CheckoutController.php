<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Cart;
use App\Models\Contract;
use App\Models\CustomerWallet;
use App\Models\Group;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Technician;
use App\Models\Transaction;
use App\Models\Visit;
use App\Notifications\SendPushNotification;
use App\Support\Api\ApiResponse;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class CheckoutController extends Controller
{
    use ApiResponse , NotificationTrait;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function checkout(Request $request)
    {
        $rules = [
            'user_address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|in:cache,visa,wallet',
            'payment_status' => 'required|in:paid,due,partial',
            'coupon' => 'nullable|numeric',
            'transaction_id' => 'nullable',
            'wallet_discounts' => 'nullable|numeric',
            'is_advance' => 'nullable',
            'is_return' => 'nullable',
            'amount' => 'nullable|numeric',
        ];
        $request->validate($rules, $request->all());
        $user = auth()->user('sanctum');
        $carts = Cart::query()->where('user_id', $user->id)->get();
        if (!$carts->first()) {
            return self::apiResponse(400, t_('Cart is empty'), []);
        }



        if ($carts->first()->type == 'package') {
            $total = $carts->first()->price;
            if ($request->payment_method == 'wallet' && $total > $user->point){
                return self::apiResponse(400, t_('Your wallet balance is not enough to complete this process'), []);
            }
            return $this->saveContract($user, $request, $total, $carts);
        } else {

            if ($request->payment_method == 'wallet' && $request->amount > $user->point){
                return self::apiResponse(400, t_('Your wallet balance is not enough to complete this process'), []);
            }
            $total = $this->calc_total($carts);
            return $this->saveOrder($user, $request, $total, $carts);
        }
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
            'payment_status' => $request->payment_status,
            'partial_amount' => ($total - $request->amount),
            'status_id' => 2,
            'is_advance' => $request->is_advance,
            'is_return' => $request->is_return,
        ]);
        foreach ($carts as $cart) {
            OrderService::create([
                'order_id' => $order->id,
                'service_id' => $cart->service_id,
                'price' => $cart->price,
                'quantity' => $cart->quantity,
                'category_id' => $cart->category_id,
            ]);
            $service = Service::query()->find($cart->service_id);
            $service?->save();
        }
        $category_ids = $carts->pluck('category_id')->toArray();
        $category_ids = array_unique($category_ids);
        foreach ($category_ids as $key => $category_id) {

            $cart = Cart::query()->where('user_id', auth('sanctum')->user()->id)
                ->where('category_id', $category_id)->first();
            $booking_no = 'dash2023/' . $cart->id;
            $minutes = 0;
            $bookSetting = BookingSetting::where('service_id', $service->id)->first();
            if ($bookSetting) {
                foreach (Service::with('BookingSetting')->whereIn('id', $carts->pluck('service_id')->toArray())->get() as $service) {
                    $serviceMinutes = ($service->BookingSetting->buffering_time + $service->BookingSetting->service_duration)
                        * $carts->where('service_id', $service->id)->first()->quantity;
                    $minutes += $serviceMinutes;
                }
            }
            $bookingInsert = Booking::query()->create([
                'booking_no' => $booking_no,
                'user_id' => auth('sanctum')->user()->id,
                'category_id' => $category_id,
                'order_id' => $order->id,
                'user_address_id' => $order->user_address_id,
                'booking_status_id' => 1,
                'notes' => $cart->notes,
                'quantity' => $cart->quantity,
                'date' => $cart->date,
                'type' => 'service',
                'time' => Carbon::parse($cart->time)->toTimeString(),
                'end_time' => $minutes? Carbon::parse($cart->time)->addMinutes($minutes)->toTimeString() : null,
            ]);

            $booking_id = Booking::where('date',$cart->date)->pluck('id')->toArray();
            $visit = DB::table('visits')
                ->select('*', DB::raw('COUNT(assign_to_id) as group_id'))
                ->whereIn('booking_id', $booking_id)
                ->groupBy('assign_to_id')
                ->orderBy('group_id', 'ASC')
                ->first();

            if ($visit == null){
                $group = Group::first();
                $assign_to_id = $group->id;
            }else{
                $assign_to_id = $visit->assign_to_id;
            }

            $start_time = Carbon::parse($cart->time)->toTimeString();
            $end_time =  $minutes? Carbon::parse($cart->time)->addMinutes($minutes)->toTimeString() : null;
            $validated['start_time'] =  $start_time;
            $validated['end_time'] = $end_time;
            $validated['duration'] = $minutes;
            $validated['visite_id'] = rand(1111, 9999) . '_' . date('Ymd');
            $validated['assign_to_id'] = $assign_to_id;
            $validated['booking_id'] = $bookingInsert->id;
            $validated['visits_status_id'] = 1;
            $visitInsert = Visit::query()->create($validated);


            $allTechn = Technician::where('group_id',$visitInsert->assign_to_id)->whereNotNull('fcm_token')->get();

            if (count($allTechn) > 0){

                $title = 'موعد زيارة جديد';
                $message = 'لديك موعد زياره جديد';

                foreach ($allTechn as $tech){
                    Notification::send(
                        $tech,
                        new SendPushNotification($title,$message)
                    );
                }

                $FcmTokenArray = $allTechn->pluck('fcm_token');

                $notification = [
                    'device_token' => $FcmTokenArray,
                    'title' => $title,
                    'message' => $message,
                    'type'=>'technician',
                    'code'=> 1,
                ];

                $this->pushNotification($notification);
            }


        }


        if ($request->payment_method == 'cache') {
//            $transaction = Transaction::create([
//                'order_id' => $order->id,
//                'transaction_number' => 'cache/' . rand(1111111111, 9999999999),
//                'payment_result' => 'success',
//                'payment_method' => $request->payment_method,
//            ]);
        } else {
            Transaction::create([
                'order_id' => $order->id,
                'transaction_number' => $request->transaction_id,
                'payment_result' => 'success',
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
            ]);
        }

        $user->update([
            'point' => $user->point - $request->wallet_discounts ?? 0
        ]);

        $this->wallet($user, $request->amount);

        Cart::query()->whereIn('id', $carts->pluck('id'))->delete();
        $this->body['order_id'] = $order->id;
        return self::apiResponse(200, t_('order created successfully'), $this->body);
    }

    private function saveContract($user, $request, $total, $carts)
    {
        $order = Contract::create([
            'user_id' => $user->id,
            'discount' => $request->coupon,
            'user_address_id' => $request->user_address_id,
            'sub_total' => $total,
            'total' => ($total - $request->coupon),
            'payment_method' => $request->payment_method,
            'status_id' => 2,
            'package_id' => $carts->first()->contract_package_id,
            'price' => ($total - $request->coupon),
            'quantity' => $carts->count(),
        ]);
        foreach ($carts as $key => $cart) {
            $booking_no = 'dash2023/' . $cart->id;
            $minutes = 0;
            foreach (Service::with('BookingSetting')->whereIn('id', $carts->pluck('service_id')->toArray())->get() as $service) {
                $serviceMinutes = ($service->BookingSetting->buffering_time + $service->BookingSetting->service_duration);
                $minutes += $serviceMinutes;
            }
            Booking::query()->create([
                'booking_no' => $booking_no,
                'user_id' => auth('sanctum')->user()->id,
                'category_id' => $cart->category_id,
                'contract_order_id' => $order->id,
                'user_address_id' => $order->user_address_id,
                'booking_status_id' => 1,
                'notes' => $cart->notes,
                'quantity' => 1,
                'package_id' => $cart->contract_package_id,
                'date' => $cart->date,
                'type' => 'contract',
                'time' => Carbon::parse($cart->time)->toTimeString(),
                'end_time' => Carbon::parse($cart->time)->addMinutes($minutes)->toTimeString(),
            ]);
        }
        if ($request->payment_method == 'cache') {
//            $transaction = Transaction::create([
//                'contract_order_id' => $order->id,
//                'transaction_number' => 'cache/' . rand(1111111111, 9999999999),
//                'payment_result' => 'success',
//                'payment_method' => $request->payment_method,
//            ]);
        } else {
            Transaction::create([
                'contract_order_id' => $order->id,
                'transaction_number' => $request->transaction_id,
                'payment_result' => 'success',
                'payment_method' => $request->payment_method,
                'amount' => $total,
            ]);
        }

        $user->update([
            'point' => $user->point - $request->wallet_discounts ?? 0
        ]);

        $this->wallet($user, $total);
        Cart::query()->whereIn('id', $carts->pluck('id'))->delete();
        $this->body['order_id'] = $order->id;
        return self::apiResponse(200, t_('order created successfully'), $this->body);
    }

    private function wallet($user, $total)
    {

        $walletSetting = CustomerWallet::query()->first();

        $wallet = ($total * $walletSetting->order_percentage) / 100;

        if ($wallet > $walletSetting->refund_amount) {
            $point = $walletSetting->refund_amount;
        } else {
            $point = $wallet;
        }
        $user->update([
            'point' => $user->point + $point ?? 0
        ]);

    }


}
