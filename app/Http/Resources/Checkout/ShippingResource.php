<?php

namespace App\Http\Resources\Checkout;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
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
            // 'address' => $this->address,
            'area'    => $this->area?->title,
            'price'   => $this->price,
            'from'    => $this->from,
            'to'      => $this->to,

        ];
    }
}
