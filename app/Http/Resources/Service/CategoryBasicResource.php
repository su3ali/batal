<?php

namespace App\Http\Resources\Service;

class CategoryBasicResource extends \Illuminate\Http\Resources\Json\JsonResource
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
        ];
    }
}
