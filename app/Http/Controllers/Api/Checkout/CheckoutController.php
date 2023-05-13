<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Bll\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checkout\AddAddressRequest;
use App\Http\Requests\Api\Checkout\CheckoutRequest;
use App\Http\Resources\Checkout\CartResource;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Core\AreaResource;
use App\Models\Area;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Paytabscom\Laravel_paytabs\paypage;


class CheckoutController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function index()
    {
        $user = auth()->user('sanctum');
        $address = UserAddress::where('user_id', $user->id)->latest()->get()->unique('address');
        $this->body['user_address'] = UserAddressResource::collection($address);

        return self::apiResponse(200, null, $this->body);
    }

    protected function addAddress(AddAddressRequest $request)
    {

        $user = auth()->user('sanctum');
        $areas = Area::query()->whereNotNull('parent_id')->where('active', 1)->get();
        $shipping = Shipping::where('area_id', $request->area_id)->where('active', 1)->first();
        $address = UserAddress::create([
            'shipping_id' => $shipping->id,
            'user_id' => $user->id,
            'address' => $request->address,
            'lat' => $request->lat,
            'lon' => $request->lon,
        ]);
        $this->body['areas'] = AreaResource::collection($areas);
        $this->body['user_address'] = UserAddressResource::make($address);

        return self::apiResponse(200, null, $this->body);
    }

    protected function getArea()
    {

        $areas = Area::query()->whereHas('shipping')->whereNotNull('parent_id')->where('active', 1)->get();
        $this->body['areas'] = AreaResource::collection($areas);

        return self::apiResponse(200, null, $this->body);
    }

    protected function checkout(CheckoutRequest $request)
    {
        $user = auth()->user('sanctum');
        $carts = Cart::query()->where('user_id', $user->id)->get();
        if (!$carts->first()) {
            return self::apiResponse(400, t_('Cart is empty'), []);
        }
        $total = $this->calc_total($carts);
        return $this->saveOrder($user, $request, $total, $carts);
    }

    private function calc_total($carts)
    {
        $total = [];
        for ($i = 0; $i < $carts->count(); $i++) {
            $cart_total = ($carts[$i]->price) * $carts[$i]->quantity;
            $total[] = $cart_total;
        }
        return array_sum($total);
    }

    private function saveOrder($user, $request, $total, $carts)
    {
        $user_address = UserAddress::query()->find($request->user_address_id);
        $order = Order::create([
            'user_id' => $user->id,
            'discount' => $request->coupon,
            'user_address_id' => $request->user_address_id,
            'sub_total' => $total,
            'address' => $user_address?->address,
            'total' => ($total - $request->coupon),
            'payment_type' => $request->payment_type == 1 ? 'cache on delivery' : 'online payment',
            'status' => 'waiting',
        ]);
        foreach ($carts as $cart) {
            if ($cart->product_id){
                $product = Product::find($cart->product_id);
                ProductOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'title' => $product?->getTranslations('title'),
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                ]);
                $product = Product::query()->find($cart->product_id);
                if ($product){
                    $product->stock = $product->stock - $cart->quantity;
                    $product->sales = ($product->sales + $cart->quantity);
                    $product->save();
                }
            }
        }
        if ($request->payment_type != 1) {
            $address = $user_address->address;
            $city = $user_address->shipping->area->title;
            $country = Area::query()->find($user_address->shipping->area->parent_id)?->title;
            $total = $total + $order->shipping?->price;
            $payment = new Payment($total, $user, $order, $address, $city, $country);
            return $payment->payment();
        }
        if ($request->payment_type == 1) {
            Cart::query()->whereIn('id', $carts->pluck('id'))->delete();
            return self::apiResponse(200, t_('order created successfully'), []);
        }

    }


    public function callbackPayment(Request $request)
    {
        $result = app(Paypage::class)->queryTransaction($request->tranRef);
        $order = Order::findOrFail($request->order_id);

        if ($result->success) {
            $carts = Cart::where('user_id', $order->user_id)->get();
            foreach ($carts as $cart){
                $product = $cart->product;
                $product->stock = $cart->product->stock - $cart->quantity;
                $product->save();
            }
            Cart::query()->whereIn('id', $carts->pluck('id'))->delete();

            Transaction::create([
                'order_id' => $request->order_id,
                'transaction_number' => $result->transaction_id,
                'payment_result' => 'success',
            ]);
            $order->status = 'paid';
            $order->save();

            $image = 'dashboard/img/media/success.png';
        } else {
            Transaction::create([
                'order_id' => $request->order_id,
                'transaction_number' => $result->transaction_id,
                'payment_result' => 'fail',
            ]);
            $image = 'dashboard/img/media/error.jpg';
        }
        return view('frontend.payment_back', compact('image'));
    }
}
