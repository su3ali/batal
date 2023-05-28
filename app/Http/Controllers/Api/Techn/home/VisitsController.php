<?php

namespace App\Http\Controllers\Api\Techn\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Technician\home\VisitsResource;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Group;
use App\Models\Order;
use App\Models\User;
use App\Models\Visit;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class VisitsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function myCurrentOrders(){

//        $visit = Visit::where('assign_to_id',auth('sanctum')->user()->group_id)->first();
//        $booking = Booking::where('id',$visit->booking_id)->first();
        $orders = Visit::whereHas('booking',function($q){
            $q->whereHas('order',function ($q){
                $q->whereHas('services')->whereHas('user',function($q){
                            $q->whereHas('address');
                        });
            });
        })->with('booking',function ($q){
            $q->with('order',function ($q){
                $q->with(['services','user'=>function($q){
                    $q->with('address');
                }]);
            });
        })->with('status')->whereIn('visits_status_id',[1,2,3,4])->where('assign_to_id',auth('sanctum')->user()->group_id)->get();

        $this->body['visits'] = VisitsResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }

    protected function myPreviousOrders(){

        $orders = Visit::whereHas('booking',function($q){
            $q->whereHas('order',function ($q){
                $q->whereHas('services')->whereHas('user',function($q){
                    $q->whereHas('address');
                })
            });
        })->with('booking',function ($q){
            $q->with('order',function ($q){
                $q->with(['services','user'=>function($q){
                    $q->with('address');
                }]);
            });
        })->with('status')->where('visits_status_id',5)->where('assign_to_id',auth('sanctum')->user()->group_id)->get();

        $this->body['visits'] = VisitsResource::collection($orders);
        return self::apiResponse(200, null, $this->body);
    }

}
