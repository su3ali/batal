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
            ->whereIn('service_id', collect($this['services'])->pluck('id')->toArray())->get();
        $order = Order::with('bookings')->find($this['order_id']);
        return [
            'id'  => $this['id'],
            'title'  => $this['title'],
            'image' => $this['slug']? asset($this['slug']) : '',
            'date' => Carbon::parse($order->bookings->first()->date)->format('d M'),
            'time_start' => Carbon::parse($order->bookings->first()->time)->format('g:i A'),
            'time_end' => Carbon::parse($order->bookings->first()->time)
                ->addMinutes(
                    array_sum($bookingSettings->pluck('service_duration')->toArray())
                    +
                    array_sum($bookingSettings->pluck('buffering_time')->toArray())
                )->format('g:i A'),
            'total_duration' => Carbon::parse($order->bookings->first()->time)
                ->addMinutes(
                    array_sum($bookingSettings->pluck('service_duration')->toArray())
                    +
                    array_sum($bookingSettings->pluck('buffering_time')->toArray())
                )->diffInMinutes(Carbon::parse($order->bookings->first()->time))
        ];
    }
}
