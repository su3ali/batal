<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ShowRoomsResource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'         => $this->id,
            'area'       => $this->area?->title,
            'address'    => $this->address,
            'lat'        => $this->lat,
            'lng'        => $this->lng,
            'start_hour' => Carbon::createFromFormat('H:i:s', $this->start_hour)->format('g:i A'),
            'end_hour'   => Carbon::createFromFormat('H:i:s', $this->end_hour)->format('g:i A'),
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
        ];
    }
}
