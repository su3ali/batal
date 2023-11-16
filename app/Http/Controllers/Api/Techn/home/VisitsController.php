<?php

namespace App\Http\Controllers\Api\Techn\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\StatusResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Technician\home\VisitsResource;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Group;
use App\Models\Order;
use App\Models\Technician;
use App\Models\TechnicianWallet;
use App\Models\User;
use App\Models\Visit;
use App\Support\Api\ApiResponse;
use App\Traits\NotificationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VisitsController extends Controller
{
    use ApiResponse;
    use NotificationTrait;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function myCurrentOrders()
    {
        $groups = Group::where('technician_id', auth('sanctum')->user()->id)->first();
        if (!$groups) {
            $this->body['visits'] = [];
            return self::apiResponse(200, null, $this->body);
        }
        $orders = Visit::whereHas('booking', function ($q) {
            $q->whereHas('customer')->whereHas('address');
        })->with('booking', function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            }, 'customer', 'address']);
        })->with('status')->whereIn('visits_status_id', [1, 2, 3, 4])->where('assign_to_id',   $groups->id)
            ->orderBy('created_at', 'desc')->get();

        $this->body['visits'] = VisitsResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }

    protected function myPreviousOrders()
    {
        $groups = Group::where('technician_id', auth('sanctum')->user()->id)->first();
        if (!$groups) {
            $this->body['visits'] = [];
            return self::apiResponse(200, null, $this->body);
        }
        $orders = Visit::whereHas('booking', function ($q) {
            $q->whereHas('customer')->whereHas('address');
        })->with('booking', function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            }, 'customer', 'address']);
        })->with('status')->whereIn('visits_status_id', [5, 6])
            ->where('assign_to_id', $groups->id)->orderBy('created_at', 'desc')->get();
        $this->body['visits'] = VisitsResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }

    protected function myOrdersByDateNow()
    {

        $groups = Group::where('technician_id', auth('sanctum')->user()->id)->first();
        if (!$groups) {
            $this->body['visits'] = [];
            return self::apiResponse(200, null, $this->body);
        }
        $orders = Visit::whereHas('booking', function ($q) {

            $q->where('date', Carbon::now('Asia/Riyadh')->format('Y-m-d'))->whereHas('customer')->whereHas('address');
        })->with('booking', function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            }, 'customer', 'address']);
        })->with('status')->whereIn('visits_status_id', [1, 2, 3, 4])
            ->where('assign_to_id',  $groups->id)->orderBy('created_at', 'desc')->get();
        $this->body['visits'] = VisitsResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }


    protected function orderDetails($id)
    {

        $order = Visit::whereHas('booking', function ($q) {
            $q->whereHas('customer')->whereHas('address');
        })->with('booking', function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            }, 'customer', 'address']);
        })->with('status')->where('id', $id)->first();
        $this->body['visits'] = VisitsResource::make($order);
        return self::apiResponse(200, null, $this->body);
    }

    protected function changeStatus(Request $request)
    {
        $rules = [
            'type' => 'required|in:visit,order,booking',
            'cancel_reason_id' => 'nullable|exists:reason_cancels,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'note' => 'nullable|string|min:3|max:255'
        ];
        if ($request->type == 'visit') {
            $rules['id'] = 'required|exists:visits,id';
            $rules['status_id'] = 'required|exists:visits_statuses,id';


            $request->validate($rules, $request->all());

            $model = Visit::with('booking.order')->where('id', $request->id)->first();

            $data = [
                'visits_status_id' => $request->status_id,
                'reason_cancel_id' => $request->cancel_reason_id,
                'note' => $request->note,
            ];
            $image = null;
            if ($request->hasFile('image')) {
                if (File::exists(public_path($model->image))) {
                    File::delete(public_path($model->image));
                }
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move(storage_path('app/public/images/visits/'), $filename);
                $image = 'storage/images/visits' . '/' . $filename;
                $data['image'] = $image;
            }

            if ($request->status_id == 3) {
                $data['start_date'] = Carbon::now('Asia/Riyadh');
                $order = $model->booking->order;
                $visits_ids = [];
                foreach ($order->bookings as $booking) {
                    $visits_ids[] = $booking->visit->id;
                }
                if (!in_array(3, $visits_ids)) {
                    $order->status_id = 3;
                    $order->save();
                }
            }

            if ($request->status_id == 5) {
                $data['end_date'] = Carbon::now('Asia/Riyadh');
                $techWallet = TechnicianWallet::query()->first();
                $serviceCost = $model->booking->order->services->where('category_id', $model->booking->category_id)->sum('price');
                if ($techWallet->point_type == 'rate') {
                    $money = $serviceCost * ($techWallet->price / 100);
                } else {
                    $money = $techWallet->price;
                }
                $techs = Technician::query()
                    ->whereIn('id', $model->group->technicians->pluck('id')->toArray())
                    ->get();
                foreach ($techs as $tech) {
                    $tech->point += $money;
                    $tech->save();
                }
            }

            $model->update($data);

            // if (in_array($request->status_id, [5,6])){
            //     if($model->booking->type =='service') {
            //         $order = $model->booking->order;
            //     }else{
            //         $order = $model->booking->contract;
            //     }
            //     $visits_ids = [];
            //     foreach ($order->bookings as $booking){
            //         $visits_ids[] = $booking->visit?->id;
            //     }
            //     $difference = array_diff($visits_ids, [1,2,3,4]);
            //     if (count($difference) == count($visits_ids)) {
            //         $order->status_id = 4;
            //         $order->save();
            //     }
            // }

            if (in_array($request->status_id, [5, 6])) {
                $order = $model->booking->order;
                $visits_ids = [];
                foreach ($order->bookings as $booking) {
                    $visits_ids[] = $booking->visit->id;
                }
                $difference = array_diff($visits_ids, [1, 2, 3, 4]);
                if (count($difference) == count($visits_ids)) {
                    $order->status_id = 4;
                    $order->save();
                }
            }
            if ($request->status_id == 6) {
                $bookingId = Visit::where('id', $request->id)->first()->booking_id;
                $order = Order::whereHas('bookings', function ($q) use ($bookingId) {
                    $q->where('id', $bookingId);
                })->first();
                $order->update([
                    'status_id' => 5
                ]);
                $booking = Booking::where('id', $bookingId)->first();
                $booking->update([
                    'booking_status_id' => 2
                ]);

                //refund

                $yourDate = Carbon::parse($booking->Date)->timezone('Asia/Riyadh');
                $currentDate = Carbon::now('Asia/Riyadh');
                $daysDifference = $yourDate->diffInDays($currentDate);
                if ($daysDifference >= 2) {
                    $user = User::where('id', $model->booking->user_id)->first();
                    $user->update([
                        'point' => $user->point + $order->total ?? 0
                    ]);
                }
            }

            $user = User::where('id', $model->booking->user_id)->first('fcm_token');

            $order = Visit::whereHas('booking', function ($q) {
                $q->whereHas('customer')->whereHas('address');
            })->with('booking', function ($q) {
                $q->with(['service' => function ($q) {
                    $q->with('category');
                }, 'customer', 'address']);
            })->with('status')->where('id', $model->id)->first();
            $visit = VisitsResource::make($order);
            $notify = [
                'fromFunc' => 'changeStatus',
                'device_token' => [$user->fcm_token],
                'data' => [
                    'order_details' => $visit,
                    'type' => 'change status',
                ]
            ];

            if ($request->status_id == 6) {
                $user = User::where('id', $model->booking->user_id)->first();
                $user->update([
                    'order_cancel' => 1
                ]);
            }

            $this->pushNotificationBackground($notify);
            //$this->pushNotification($notify);
            $this->body['visits'] = $visit;
            return self::apiResponse(200, null, $this->body);
        }
    }

    // public function test(){
    //     $order = Visit::where('id',286)->with('booking', function ($q) {
    //         $q->with(['service' => function ($q) {
    //             $q->with('category');
    //         },'customer','address']);

    //     })->with('status')->first();
    //     $visit = VisitsResource::make($order);
    //     $notify = [
    //         'fromFunc'=>'changeStatus',
    //         'device_token'=>'',
    //         'data' =>[
    //             'order_details'=>$visit,
    //             'type'=>'change status',
    //         ]
    //     ];
    //     $this->pushNotificationBackground($notify);
    // }
    protected function sendLatLong(Request $request)
    {
        $rules = [
            'lat' => 'required',
            'long' => 'required',
        ];


        $request->validate($rules, $request->all());

        //  $techn = Technician::where('id',auth('sanctum')->user()->id)->first();
        $groups = Group::where('technician_id', auth('sanctum')->user()->id)->first();
        $model = Visit::query()->where('assign_to_id', $groups->id)->where('visits_status_id', 2)->first();

        if (!$model) {
            return self::apiResponse(400, __('api.visit not found'), $this->body);
        }

        $model->update([
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        $user = User::where('id', $model->booking->user_id)->first('fcm_token');

        $notify = [
            'fromFunc' => 'latlong',
            'device_token' => [$user->fcm_token],
            'data' => [
                'visit_id' => $model->id,
                'booking_id' => $model->booking_id,
                'order_id' => $model->booking?->order_id,
                'lat' => $request->lat,
                'long' => $request->long,
                'type' => 'live location',
            ]
        ];

        $this->pushNotificationBackground($notify);
        //$this->pushNotification($notify);
        return self::apiResponse(200, __('api.Update Location successfully'), $this->body);
    }

    protected function paid(Request $request)
    {
        $rules = [
            'order_id' => 'required',
        ];

        $request->validate($rules, $request->all());

        $order = Order::query()->where('id', $request->order_id)->first();

        $order->update([
            'partial_amount' => 0
        ]);

        return self::apiResponse(200, __('api.successfully'), $this->body);
    }


    protected function change_order_cancel(Request $request)
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
        ];

        $request->validate($rules, $request->all());


        $user = User::where('id', $request->user_id)->first();
        $user->update([
            'order_cancel' => 1
        ]);

        return self::apiResponse(200, __('api.successfully'), $this->body);
    }
}
