<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Facility\FacilityResource;
use App\Models\Area;
use App\Models\Facility;
use App\Models\Order;
use App\Models\OrdersStores;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $from = Carbon::parse($this->days->where('day', Carbon::now()->locale('en')->dayName)->first()?->from);
        $to = Carbon::parse($this->days->where('day', Carbon::now()->locale('en')->dayName)->first()?->to);
        $open = t_('close');
        if (Carbon::now() >= $from && Carbon::now() <= $to){
            $open = t_('open');
        }
        $facilities = Facility::query()->whereIn('id', $this->storeFacilities->where('active', 1)->where('facility_id', '!=', 1)->pluck('facility_id')->toArray())->get();
        if ($facilities->isEmpty()) {
            $facilities = Facility::query()->whereIn('id', $this->storeFacilities->where('facility_id', 4)->pluck('facility_id')->toArray())->get();
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'main_category' => $this->main_category->title,
            'description' => $this->description,
            'rating' => number_format($this->rate?->average('rate'), 1)? : 0,
            'area' => $this->address? : '',
            'logo' => $this->logo,
            'cover' => $this->cover,
            'lat' => $this->latitude,
            'long' => $this->longitude,
            'categories' => CategoryResource::collection($this->categories),
            'hours_from' => $from->format('g:i a'),
            'hours_to' => $to->format('g:i a'),
            'open' => $open,
            'facilities' => FacilityResource::collection($facilities),
            'custom_order' => $this->facilities->where('id', 1)->first()->pivot->active == 1
        ];
    }
}
