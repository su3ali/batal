<?php

namespace App\Http\Resources\Technician\home;

use App\Http\Resources\Service\ServiceByCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;


class VisitsResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'status' => $this->status->name,
            'booking_no' => $this->booking?->booking_no,
            'user' => UserResource::make($this->booking->customer),
            'service' => ServiceByCategoryResource::make($this->booking->service),
            'created_at' => $this->created_at,
        ];
    }
}
