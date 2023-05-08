<?php

namespace App\Http\Resources\Facility;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Area;
use App\Models\Order;
use App\Models\OrdersStores;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
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
            'type' => $this->type
        ];
    }
}
