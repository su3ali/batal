<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'image' => asset($this->slug),
            'products' => $this->products? ProductResource::collection($this->products) : ''
        ];
    }
}
