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
use App\Models\User;
use App\Models\Visit;
use App\Support\Api\ApiResponse;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VisitsController extends Controller
{
    use ApiResponse;
    use NotificationTrait;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function myCurrentOrders()
    {

        $orders = Visit::whereHas('booking', function ($q) {
            $q->whereHas('customer')->whereHas('address');

        })->with('booking', function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            },'customer','address']);

        })->with('status')->whereIn('visits_status_id', [1, 2, 3, 4])->where('assign_to_id', auth('sanctum')->user()->group_id)
            ->get();

        $this->body['visits'] = VisitsResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }

    protected function myPreviousOrders()
    {

        $orders = Visit::whereHas('booking', function ($q) {
            $q->whereHas('customer')->whereHas('address');

        })->with('booking', function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            },'customer','address']);

        })->with('status')->whereIn('visits_status_id', [5, 6])->where('assign_to_id', auth('sanctum')->user()->group_id)->get();
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
            },'customer','address']);

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

            $model = Visit::query()->where('id', $request->id)->first();

            $data = [
                'visits_status_id' => $request->status_id,
                'reason_cancel_id' => $request->cancel_reason_id,
                'note' => $request->note,
            ];
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
            $model->update($data);


            $user = User::where('id',$model->booking->user_id)->first('fcm_token');


            $notify = [
                'device_token'=>$user->fcm_token,
                'data' =>[
                    'visit_id'=>$request->id,
                    'booking_id'=>$model->booking_id,
                    'order_id'=>$model->booking?->order_id,
                    'image'=>$image,
                    'visit_status'=>StatusResource::make($model->visits_status_id),
                    'type'=>'change status',
                ]
            ];

            $this->pushNotificationBackground($notify);

            return $this->orderDetails($model->id);
        }

    }
    protected function sendLatLong(Request $request)
    {
        $rules = [
            'lat' => 'required',
            'long' => 'required',
        ];


        $request->validate($rules, $request->all());

        $techn = Technician::where('id',auth('sanctum')->user()->id)->first();

        $model = Visit::query()->where('assign_to_id', $techn->group_id)->where('visit_status_id',2)->first();

        $user = User::where('id',$model->booking->user_id)->first('fcm_token');


        $notify = [
            'device_token'=>$user->fcm_token,
            'data' =>[
                'visit_id'=>$model->id,
                'booking_id'=>$model->booking_id,
                'order_id'=>$model->booking?->order_id,
                'lat'=>$request->lat,
                'long'=>$request->long,
                'type'=>'live location',
            ]
        ];

        $this->pushNotificationBackground($notify);

        return self::apiResponse(200, t_('Update Location successfully'), $this->body);

    }

}
