<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'id'    => $this->id,
            'title' => $this->title,
            'space_km' => $this->space_km,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'polygon_coordinates' => json_decode($this->polygon_coordinates)
        ];
    }
}
