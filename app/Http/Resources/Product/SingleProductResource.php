<?php

namespace App\Http\Resources\Product;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cat = Product::query()->find($this->id)->category->id;
        $similarProducts = Product::query()->where('id', '!=', $this->id)->where('category_id', $cat)->paginate(4);
//        dd($similarProducts);
        return [
            'id' => $this->id,
            'images' => $this->getMedia('images')->pluck('original_url') ,
            'cover' => $this->getCoverAttribute(),
            'title' => $this->title,
            'stock' => $this->stock,
            'has_sizes' => $this->has_sizes == 1,
            'description' => $this->description,
            'price' => $this->price + ($this->price * 0.15),
            'min' => $this->min + ($this->min * 0.15),
            'mid' => $this->mid + ($this->mid * 0.15),
            'large' => $this->large + ($this->large * 0.15),
            'price_before' => $this->price_before + ($this->price_before * 0.15),
            'similar' => SimilarProductsResource::collection($similarProducts),
            'additions' => AdditionsResource::collection($this->additions->where('active', '!=', null)),
            'rate' => number_format($this->rate->average('rate'), 1)
        ];
    }
}
