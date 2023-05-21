<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        $images = [];
        foreach ($this->services as $service){
            foreach ($service->serviceImages as $serviceImage){
                if ($serviceImage->image){
                    $images[] = asset($serviceImage->image);
                }
            }
        }
        $bookingSettings = BookingSetting::query()->where('service_id', $this->service?->id)->first();
        return [
            'id' => $this->id,
            'status' => $this->status->name,
            'categories' => ServiceCategoryResource::collection($this->categories),
            'date' => Carbon::parse($this->bookings->first()->date)->format('d M'),
            'time_start' => Carbon::parse($this->bookings->first()->time)->format('g:i A'),
            'time_end' => Carbon::parse($this->bookings->first()->time)
                ->addMinutes((($bookingSettings?$bookingSettings->service_duration : 0) +
                        ($bookingSettings?$bookingSettings->buffering_time : 0)) * $this->quantity)->format('g:i A'),
        ];
    }
}
