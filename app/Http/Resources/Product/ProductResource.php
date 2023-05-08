<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $min = [
            'title' => 'min',
            'price' => $this->min
        ];
        $mid = [
            'title' => 'mid',
            'price' => $this->mid
        ];
        $large = [
            'title' => 'large',
            'price' => $this->large
        ];
        return [
            'id' => $this->id,
            'price' => $this->price,
            'has_sizes' => $this->has_sizes == 1,
            'sizes' => [
                (object)$min, (object)$mid, (object)$large
            ],
            'price_before' => $this->price_before + ($this->price_before * 0.15),
            'title' => $this->title,
            'description' => $this->description,
            'stock' => $this->stock,
            'images' => $this->getMedia('images')->first()->original_url,
            'additions' => $this->additions? AdditionsResource::collection($this->additions->where('active', '!=', null)) : '',
            'rate' => number_format($this->rate->average('rate'), 1)
        ];
    }
}
