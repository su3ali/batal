<?php

namespace App\Http\Resources\Service;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class IconResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'image' => asset($this->image),
        ];
    }
}
