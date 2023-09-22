<?php

namespace App\Http\Resources\Facility;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Area;
use App\Models\Order;
use App\Models\OrdersStores;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityOrderResource extends JsonResource
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
            'type' => $this->type,
            'active' => $this->pivot->active == 0,
            'cost' => $this->pivot?->cost,
            'persons' => $this->pivot?->persons,
            'address' => $this->pivot?->address,
            'notes' => $this->pivot?->notes,
            'description_custom' => $this->pivot?->description_custom,
            'date' => $this->pivot?->date,
            'time' => $this->pivot?->time,
            'in_car' => $this->pivot?->in_car,
        ];
    }
}
