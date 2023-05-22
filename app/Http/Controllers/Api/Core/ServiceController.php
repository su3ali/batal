<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Service\ServiceDetailsResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function orderedServices(){
        $buyServiceLists = Order::query()->select('service_id',DB::raw('count(*) as total'))
            ->groupBy('service_id')
            ->orderBy('total', 'DESC')
            ->get();

        $mostSellingServices = Service::query()->whereIn('id', $buyServiceLists->pluck('service_id'))
            ->get();
        $this->body['most_ordered_services'] = ServiceResource::collection($mostSellingServices);
        return self::apiResponse(200, null, $this->body);

    }
    protected function allServices(){
        $services = Service::with('serviceImages')->get();
        $this->body['all_services'] = ServiceResource::collection($services);
        return self::apiResponse(200, null, $this->body);
    }
    protected function getServiceFromCategory($id){
        $servicesCategory = Category::query()->where('id', $id)->first();
        if ($servicesCategory){
            $services = $servicesCategory->services;
            $this->body['category_services'] = ServiceResource::collection($services);
            return self::apiResponse(200, null, $this->body);
        }
        return self::apiResponse(400, 'category not found', $this->body);
    }
    protected function serviceDetails($id){
        $service = Service::query()->where('id', $id)->first();
        if ($service){
            $this->body['service'] = ServiceDetailsResource::make($service);
            return self::apiResponse(200, null, $this->body);
        }
        return self::apiResponse(400, 'service not found', $this->body);
    }
}