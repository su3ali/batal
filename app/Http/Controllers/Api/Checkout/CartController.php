<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Bll\ControlCart;
use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\CartResource;
use App\Models\Cart;
use App\Models\Service;
use App\Support\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function add_to_cart(Request $request): JsonResponse
    {
        $service = Service::with('category')->find($request->service_id);

        if ($service && $service->active === 1) {
            $cart = Cart::query()->where('user_id', auth()->user()->id)->where('service_id', $service->id)
                ->first();
            if ($cart) {
//                return self::apiResponse(400, t_('Already In Your Cart!'), $this->body);
            }
            Cart::query()->create([
                'user_id' => auth()->user()->id,
                'service_id' => $service->id,
                'category_id' => $service->category->id,
                'price' => $service->price,
                'quantity' => $request->quantity
            ]);
            $carts = Cart::query()->where('user_id', auth()->user()->id)->count();
            $this->body['total_items_in_cart'] = $carts;
            return self::apiResponse(200, t_('Added To Cart Successfully'), $this->body);
        }
        return self::apiResponse(400, t_('service not found or an error happened.'), $this->body);

    }


    protected function index(): JsonResponse
    {
        $carts = Cart::query()->where('user_id', auth()->user()->id)->get();

        $cat_ids = $carts->pluck('category_id');
        $this->body['carts'] = [];
        foreach ($cat_ids as $cat_id){
            if ($cat_id){
                $this->body['carts'][$cat_id] = CartResource::collection($carts->where('category_id', $cat_id));
            }
        }
        if ($carts) {
            $total = number_format($this->calc_total($carts), 2, '.', '');

            $this->body['total'] = $total;
        }
        return self::apiResponse(200, null, $this->body);
    }


    protected function controlItem(Request $request): JsonResponse
    {
        $cart = Cart::query()->find($request->cart_id);
        if ($cart) {
            if (request()->action == 'delete'){
                $cart->delete();
                $response = ['success' => 'deleted successfully'];
                return self::apiResponse(200, $response['success'], $this->body);
            }
            $service = service::query()->where('id', $cart->service_id)->first();
            if ($service) {
                $controlClass = new ControlCart();
                $response = $controlClass->makeAction($request->action, $cart, $service);

                $carts = Cart::query()->where('user_id', auth()->user()->id)->get();
                $total = number_format($this->calc_total($carts), 2);
                if (key_exists('success', $response)) {
                    $this->body['total'] = $total;
                    $this->body['carts'] = CartResource::collection($carts);
                    return self::apiResponse(200, $response['success'], $this->body);
                } else {
                    return self::apiResponse(400, $response['error'], $this->body);
                }
            }
        }
        return self::apiResponse(400, t_('Cart Not Found'), $this->body);

    }

    private function calc_total($carts)
    {
        $total = [];
        for ($i = 0; $i < $carts->count(); $i++) {
            $cart_total = ($carts[$i]->price) * $carts[$i]->quantity;
            array_push($total, $cart_total);
        }
        $total = array_sum($total);
        return $total;
    }
}
