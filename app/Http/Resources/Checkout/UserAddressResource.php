<?php

namespace App\Http\Resources\Checkout;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'address' => $this->address,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'is_default' => $this->is_default,
            'active' => $this->active,
            'lat' => $this->lat,
            'long' => $this->long,
            'phone' => $this->phone,
            'region_id' => $this->region_id,
        ];
    }
}
