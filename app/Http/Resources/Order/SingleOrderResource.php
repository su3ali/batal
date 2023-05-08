<?php

namespace App\Http\Resources\Order;
use App\Http\Resources\Facility\FacilityOrderResource;
use App\Http\Resources\Facility\FacilityResource;
use App\Http\Resources\Product\AdditionsResource;
use App\Http\Resources\Product\ProductResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'type'              => $this->type? :'original',
            'products'          => $this->products() ? ProductOrderResource::collection($this->products()->get()): [],
            'order_number'      => 'PO-'.$this->id,
            'address'           => $this->address,
            'date'              => dates($this->created_at),
            'status'            => $this->status,
            'products_amount'   => $this->products?->get()->count(),
            'image'             => $this->stores?->first()?->getMedia('logo')->first()?->original_url,
            'facilities'        => FacilityOrderResource::collection($this->facilities),
            'subTotal'          => number_format($this->sub_total - (($this->total * 0.15) / 1.15), 2),
            'discount'          => $this->discount?:0,
            'value_added'       => number_format(($this->total * 0.15) / 1.15, 2),
            'delivery_cost'     => $this->delivery_cost,
            'total'             => $this->total + $this->delivery_cost,
            'refundable'        => Carbon::parse($this->created_at)->addDays(14) > Carbon::now() && $this->status == 'complete'? 'true': 'false'
        ];
    }
}
