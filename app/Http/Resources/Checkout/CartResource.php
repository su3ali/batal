<?php

namespace App\Http\Resources\Checkout;

use App\Http\Resources\Product\AdditionsResource;
use App\Models\Addition;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $adds_ids = $this->cart_additions->pluck('addition_id')->toArray();
        $adds_obj = Addition::query()->whereIn('id', $adds_ids)->get();
        $adds = array_sum($adds_obj->pluck('price')->toArray());
        if ($this->size == 'none'){
            $price = $this->product?->price;
        }else{
            $price = $this->product? $this->product[$this->size] : '';
        }
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_title' => $this->product?->title,
            'quantity' => $this->quantity,
            'size' => $this->size,
            'product_image' => $this->product?->getMedia('images')->first()->original_url,
            'additions' => AdditionsResource::collection($adds_obj),
            'price' => (($price + $adds) * $this->quantity),
        ];
    }
}
