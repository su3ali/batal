<?php

namespace App\Http\Resources\Technician\home;

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
            'user' => UserResource::make($this->booking->order->user),
            'service' => ServiceResource::collection($this->booking->order->services),
            'created_at' => $this->created_at,
        ];
    }
}
