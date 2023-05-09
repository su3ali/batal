<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Service\ServiceResource;
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
}
