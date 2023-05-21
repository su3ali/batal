<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Service\ServiceResource;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $bookingSettings = BookingSetting::query()
            ->where('service_id', collect($this['services'])->first()['id'])->first();
        $order = Order::with('bookings')->find($this['order_id']);
        return [
            'id'  => $this['id'],
            'title'  => $this['title'],
            'image' => $this['slug']? asset($this['slug']) : '',
            'services' => ServiceResource::collection(collect($this['services'])),
            'date' => Carbon::parse($order->bookings->first()->date)->format('d M'),
            'time_start' => Carbon::parse($order->bookings->first()->time)->format('g:i A'),
            'time_end' => Carbon::parse($order->bookings->first()->time)
                ->addMinutes((($bookingSettings?$bookingSettings->service_duration : 0) +
                        ($bookingSettings?$bookingSettings->buffering_time : 0)) * $this->quantity)->format('g:i A'),
        ];
    }
}
