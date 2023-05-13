<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ProductResource;
use App\Models\BookingSetting;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        $images = [];
        foreach ($this->service->serviceImages as $serviceImage){
            if ($serviceImage->image){
                $images[] = asset($serviceImage->image);
            }
        }
        $bookingSettings = BookingSetting::query()->where('service_id', $this->service?->id)->first();
        return [
            'id' => $this->id,
            'status' => $this->status->name,
            'service_main_category' => [
                'category_id' => $this->service?->category->id,
                'category_name' => $this->service?->category->title,
                'category_image' => $this->service?->category->slug? asset($this->service?->category->slug) : '',
                'category_service' => [
                    'service_id' => $this->service?->id,
                    'service_name' => $this->service?->title,
                    'service_price' => $this->price,
                    'service_quantity' => $this->quantity,
                    'service_images' => $images,
                    'notes' => $this->notes
                ]
            ],
            'date' => Carbon::parse($this->bookings->first()->date)->format('d M'),
            'time_start' => Carbon::parse($this->bookings->first()->time)->format('g:i A'),
            'time_end' => Carbon::parse($this->bookings->first()->time)
                ->addMinutes(($bookingSettings->service_duration + $bookingSettings->buffering_time) * $this->quantity)->format('g:i A'),
        ];
    }
}
