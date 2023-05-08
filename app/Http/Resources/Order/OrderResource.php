<?php

namespace App\Http\Resources\Order;
use App\Http\Resources\Product\ProductResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'date'              => dates($this->created_at),
            'status'            => $this->status,
            'type'              => $this->type? :'original',
            'products_amount'   => $this->products()?->get()->count(),
            'title'             => $this->stores?->first()?->title,
            'image'             => $this->stores?->first()?->getLogoAttribute(),
            'total'             => $this->total,
            'refundable'        => Carbon::parse($this->created_at)->addDays(14) > Carbon::now() && $this->status == 'complete'? 'true': 'false'
        ];
    }
}
