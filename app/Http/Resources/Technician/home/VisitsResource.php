<?php

namespace App\Http\Resources\Technician\home;

use App\Http\Resources\Booking\BookingResource;
use App\Http\Resources\Booking\GroupResource;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Order\StatusResource;
use App\Http\Resources\Service\ServiceByCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\User\UserResource;
use App\Models\ReasonCancel;
use App\Models\VisitsStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class VisitsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'group' => GroupResource::make($this->group),
            'all_statuses' => StatusResource::collection(VisitsStatus::all()),
            'all_cancel_reasons' => CancelReasonsResource::collection(ReasonCancel::all()),
            'booking_details' => BookingResource::make($this->booking),
            'user' => UserResource::make($this->booking->customer),
            'address' => UserAddressResource::make($this->booking->address),
            'note' => $this->note,
            'start_date' => $this->start_date ?? null,
            'end_date' => $this->end_date ?? null,
            'image' => $this->image?asset($this->image) : null,
            'cancel_reason' => $this->cancelReason? CancelReasonsResource::make($this->cancelReason) : null,
        ];
    }
}
