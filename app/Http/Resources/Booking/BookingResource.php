<?php

namespace App\Http\Resources\Booking;

use App\Models\BookingSetting;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->booking_status->name,
            'category_service' => $this->service?->category?->title,
            'image' => $this->service?->category->slug? asset($this->service?->category->slug) : '',
            'date' => Carbon::parse($this->date)->format('d M'),
            'time_start' => Carbon::parse($this->time)->format('g:i A'),
            'time_end' => Carbon::parse($this->time)
                ->addMinutes(($this->service->BookingSetting->service_duration + $this->service->BookingSetting->buffering_time) * $this->quantity)->format('g:i A'),
        ];
    }
}
