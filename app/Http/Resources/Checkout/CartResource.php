<?php

namespace App\Http\Resources\Checkout;

use App\Http\Resources\service\AdditionsResource;
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
        $images = [];
        foreach ($this->service->serviceImages as $serviceImage) {
            if ($serviceImage->image) {
                $images[] = asset($serviceImage->image);
            }
        }
        return [
            'id' => $this->id,
            'service_id' => $this->service_id,
            'category_id' => $this->service->category->id,
            'category_title' => $this->service->category->title,
            'service_title' => $this->service?->title,
            'quantity' => $this->quantity,
            'service_image' => $images,
            'price' => $this->contract_package_id ? $this->price : ($this->price * $this->quantity),
            'package_id' => $this->contract_package_id,
            'type' => $this->type,
            'package_name' => $this->type == 'package'? $this->package->name : null
        ];
    }
}
