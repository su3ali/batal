<?php

namespace App\Http\Resources\Coupons;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
{
    public function toArray($request)
    {
        $image = '';
        if ($this->category){
            $image = $this->category->slug? asset($this->category->slug) : '';
        }
        if ($this->service){
            foreach ($this->service->serviceImages as $serviceImage){
                if ($serviceImage->image){
                    $image = asset($serviceImage->image);
                }
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'code' => $this->code,
            'service_id' => $this->service_id,
            'category_id' => $this->category_id,
            'start' => $this->start,
            'end' => $this->end,
            'value_type' => $this->type,
            'value' => $this->value,
            'image' => asset($this->image? : 'images/default.jpg')
        ];
    }
}
