<?php

namespace App\Http\Controllers\Api\Statuses;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\StatusResource;
use App\Models\BookingStatus;
use App\Models\OrderStatus;
use App\Models\VisitsStatus;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function bookingsStatuses(){
        $bookingsStatuses = BookingStatus::query()->where('active', 1)->get();
        $this->body['bookings_statuses'] = StatusResource::collection($bookingsStatuses);
        return self::apiResponse(200, null, $this->body);
    }

    protected function ordersStatuses(){
        $ordersStatuses = OrderStatus::query()->where('active', 1)->get();
        $this->body['orders_statuses'] = StatusResource::collection($ordersStatuses);
        return self::apiResponse(200, null, $this->body);
    }
    protected function visitsStatuses(){
        $visitsStatuses = VisitsStatus::query()->where('active', 1)->get();
        $this->body['visits_statuses'] = StatusResource::collection($visitsStatuses);
        return self::apiResponse(200, null, $this->body);
    }

}
