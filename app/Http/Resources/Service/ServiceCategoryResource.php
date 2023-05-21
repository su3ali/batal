<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
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

            'id'  => $this['id'],
            'title'  => $this['title'],
            'image' => $this['slug']? asset($this['slug']) : '',
            'services' => ServiceResource::collection(collect($this['services']))
        ];
    }
}
