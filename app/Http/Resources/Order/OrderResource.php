<?php

namespace App\Http\Resources\Order;

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
        $images = [];
        foreach ($this->services as $service){
            foreach ($service->serviceImages as $serviceImage){
                if ($serviceImage->image){
                    $images[] = asset($serviceImage->image);
                }
            }
        }
        $cats = $this->categories;
        $categories = Category::query()->whereIn('id', $cats->pluck('id'))->get();
        $order_id = $this->id;
        foreach ($categories as $key => $category){
            $category->order_id = $order_id;
            $category->services = $cats[$key]['services'];
        }
        return [
            'id' => $this->id,
            'status' => $this->status->name,
            'categories' => OrderCategoryResource::collection($categories),
            'notes' => $this->notes,
            'total' => $this->total
        ];
    }
}
