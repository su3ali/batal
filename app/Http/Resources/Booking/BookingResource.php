<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\Contract\ContractResource;
use App\Http\Resources\Order\StatusResource;
use App\Http\Resources\Service\CategoryBasicResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\VisitsStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        $services = $this->order?->services->where('category_id', $this->category->id);

        return [
            'id' => $this->id,
            'booking_no' => $this->booking_no,
            'status' => $this->visit? StatusResource::make($this->visit->status) : null,
            'category' => CategoryBasicResource::make($this->category),
            'services' => $services ? ServiceResource::collection($services) : null,
            'contract' => ContractResource::make($this->contract),
            'image' => $this->category->slug? asset($this->category->slug) : '',
            'date' => Carbon::parse($this->date)->format('d M'),
            'time_start' => Carbon::parse($this->time)->format('g:i A'),
            'time_end' => $this->end_time
        ];
    }
}
