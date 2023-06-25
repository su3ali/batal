<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Contract\ContractResource;
use App\Http\Resources\MainCategory\MainCategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ContractPackage;
use App\Models\Order;
use App\Models\Service;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function index(Request $request)
    {
        $addresses = UserAddresses::query()->where('user_id', auth()->user('sanctum')->id)->get();
        $this->body['addresses'] = UserAddressResource::collection($addresses);
        $images = [];
        $banners = Banner::query()->where('active',1)->get();
        if ($banners->count() > 0) {
            foreach ($banners as $banner) {
                $url = $banner->image ? asset($banner->image) : '';
                if ($url) {
                    $images[] = $url;
                }
            }
        }
        $this->body['banners'] = $images;
//        $buyServiceLists = Order::query()->select('service_id',DB::raw('count(*) as total'))
//            ->groupBy('service_id')
//            ->orderBy('total', 'DESC')
//            ->get();

        $mostSellingServices = Service::query()->where('best_seller',1)
            ->where('active',1)->take(9)
            ->get()->shuffle();
        $this->body['services_most_wanted'] = ServiceResource::collection($mostSellingServices);
        $this->body['services'] = ServiceResource::collection(Service::query()->where('active', 1)->get()->shuffle());
        $this->body['contracts'] = ContractResource::collection(ContractPackage::query()->where('active', 1)->take(9)->get()->shuffle());
        $this->body['total_items_in_cart'] = auth()->user()->carts->count();
        $servicesCategories = Category::query()->where('active', 1)->get();
        $this->body['services_categories'] = ServiceCategoryResource::collection($servicesCategories);


        return self::apiResponse(200, null, $this->body);
    }

    private function nearBy($Latitude, $Longitude): Builder
    {
        $query = Store::query()->whereNot('active', 0)->select();
        $haversine = "(6371
    * acos(cos(radians($Latitude))
     * cos(radians(latitude))
     * cos(radians(longitude)
     - radians($Longitude))
     + sin(radians($Latitude))
     * sin(radians(latitude))))";
        return $query->selectRaw("{$haversine} AS distance");
    }

    protected function search(Request $request): JsonResponse
    {
        if ($request->title) {
            $services = Service::query()->where('title_ar', 'like', '%'.$request->title.'%')
                ->orWhere('title_en', 'like', '%'.$request->title.'%')->where('active', 1)->get();
            $this->body['services'] = ServiceResource::collection($services);
            return self::apiResponse(200, '', $this->body);
        } else {
            return self::apiResponse(200, t_('No Services was founded.'), null);
        }
    }

    protected function filter(Request $request): JsonResponse
    {
        if ($request->title) {
            $products = Product::query()
                ->whereNot('active', 0)
                ->where('title', 'LIKE', '%' . $request->title . '%');
            $stores = Store::query()
                ->whereNot('active', 0)
                ->where('title', 'LIKE', '%' . $request->title . '%');
        } else {
            $products = Product::query()
                ->whereNot('active', 0);
            $stores = Store::query()
                ->whereNot('active', 0);
        }
        if ($products->get()->isNotEmpty()) {
            if ($request->sort_type == 'alpha') {
                $products = $products->orderBy('title', 'desc');
            }
            $products = ProductResource::collection($products->get());
            if ($request->sort_type == 'rate') {
                $products = $products->sortByDesc('rate');
            }
            $this->body['products'] = $products;
        } else {
            $this->body['products'] = [];
        }
        if ($stores->get()->isNotEmpty()) {
            if ($request->sort_type == 'alpha') {
                $stores = $stores->orderBy('title', 'desc');
            }
            $stores = StoreResource::collection($stores->get());
            if ($request->sort_type == 'rate') {
                $stores = $stores->sortByDesc('rate');
            }
            $this->body['stores'] = $stores;
        } else {
            $this->body['stores'] = [];
        }
        if ($products->isNotEmpty() || $stores->get()->isNotEmpty()) {
            return self::apiResponse(200, t_(''), $this->body);
        } else {
            return self::apiResponse(400, t_('No products or stores was founded.'), $this->body);
        }
    }

    protected function rate(Request $request): JsonResponse
    {
        $request->validate([
            'ratable_id' => 'required',
            'ratable_type' => 'required',
            'rate' => 'required'
        ]);
        if ($request->ratable_type) {
            if ($request->ratable_type == 'Product') {
                $rated_object = Product::query()->find($request->ratable_id);
            } else if ($request->ratable_type == 'Order') {
                $rated_object = Store::query()->where('id', OrdersStores::query()
                    ->where('order_id', $request->ratable_id)->first()->store_id)->first();
            }
            $rate = new Rating(['rate' => $request->rate]);
            if (isset($rated_object)) {
                $rated_object->rate()->save($rate);
                return self::apiResponse(200, 'Thanks for rating!', $this->body);
            } else {
                return self::apiResponse(400, 'Oops! An Error Occurred, please try again.', $this->body);
            }
        } else {
            return self::apiResponse(400, 'Oops! An Error Occurred, please try again.', $this->body);
        }
    }

    protected function view_all()
    {
        $stores = [];
        if (request('key') == 'popular') {
            $stores = Store::whereNot('active', 0)->orderBy('sales', 'desc')->paginate(request('paginate') ?: 10);
        }
        if (request('key') == 'nearby' && request('latitude') && request('longitude')) {
            $stores = $this->nearBy(request('latitude'), request('longitude'))->get()->where('distance', '<=', 2000);
        }
        if (request('key') == 'alpha') {
            $stores = Store::query()->whereNot('active', 0)->orderBy('title', 'desc')->paginate(request('paginate') ?: 10);
        }
        if (request('key') == 'rate') {
            $stores = Store::query()->whereNot('active', 0)->paginate(request('paginate') ?: 10);
            $stores = $stores->sortBy('rate');
        }
        $this->body['stores'] = StoreResource::collection($stores);
        return self::apiResponse(200, t_(''), $this->body);
    }

}
