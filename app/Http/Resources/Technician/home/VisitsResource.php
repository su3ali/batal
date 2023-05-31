<?php

namespace App\Http\Resources\Technician\home;

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
            'status' => StatusResource::make($this->status),
            'all_statuses' => StatusResource::collection(VisitsStatus::all()),
            'all_cancel_reasons' => CancelReasonsResource::collection(ReasonCancel::all()),
            'booking_no' => $this->booking?->booking_no,
            'user' => UserResource::make($this->booking->customer),
            'address' => UserAddressResource::make($this->booking->address),
            'service' => ServiceByCategoryResource::make($this->booking->service),
            'note' => $this->note,
            'image' => asset($this->image),
            'cancel_reason' => $this->cancelReason? CancelReasonsResource::make($this->cancelReason) : null,
            'created_at' => Carbon::make($this->created_at)->toDateTimeString(),
        ];
    }
}
