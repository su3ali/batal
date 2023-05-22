<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailsResource extends JsonResource
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
            'description' => $this->description,
            'images' => $images,
            'price' => $this->price,
            'type' => $this->type,
            'duration' => $this->duration,
            'terms_and_conditions' => $this->ter_cond,
        ];
    }
}