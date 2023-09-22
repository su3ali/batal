<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\Order\StatusResource;
use App\Http\Resources\Service\CategoryBasicResource;
use App\Http\Resources\Technician\auth\TechnicianResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'lat' => "24.7234959",
            'lon' => "46.8169113",
            'name' => $this->name,
            'leader' => TechnicianResource::make($this->leader)
        ];
    }
}
