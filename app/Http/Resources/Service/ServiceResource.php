<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = [];
        foreach ($this->serviceImages as $serviceImage){
            if ($serviceImage->image){
                $images[] = asset($serviceImage->image);
            }
        }
        return [

            'id'  => $this->id,
            'title'  => $this->title,
            'price' => $this->price,
            'images' => $images
        ];
    }
}
