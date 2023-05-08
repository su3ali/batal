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
            'shipping'=> ShippingResource::make($this->shipping),
            'area'    => $this->shipping?->area->title,
            'area_id'    => $this->shipping?->area->id,
            'user_id' => $this->user_id,
        ];
    }
}
