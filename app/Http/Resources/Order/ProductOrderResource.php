<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\AdditionsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'quantity' => $this->pivot->quantity,
            'stock' => $this->stock,
            'image' => $this->getCoverAttribute(),
            'price' => ($this->price + ($this->price * 0.15)) * $this->pivot->quantity,
            'additions' => AdditionsResource::collection($this->additions)

        ];
    }
}
