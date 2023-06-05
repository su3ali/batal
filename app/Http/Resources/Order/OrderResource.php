<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Booking\BookingResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\BookingSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status->name,
            'categories' => BookingResource::collection($this->bookings),
            'notes' => $this->notes,
            'total' => $this->total
        ];
    }
}
