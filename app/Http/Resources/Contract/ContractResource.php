<?php

namespace App\Http\Resources\Contract;

use App\Http\Resources\Service\IconResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'visit_number' => $this->visit_number,
            'image' => asset($this->image),
            'service_icons' => IconResource::collection($this->service->icons),
            'service' => ServiceResource::make($this->service),
        ];
    }
}
