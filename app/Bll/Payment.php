<?php

namespace App\Bll;


use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Paytabscom\Laravel_paytabs\paypage;

class Payment
{
    use ApiResponse;

    public $total, $user, $order, $address, $city, $country;

    public function __construct($total, $user, $order, $address, $city, $country)
    {
        $this->total = $total;
        $this->user = $user;
        $this->order = $order;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
    }

    public function payment()
    {
        $pay = app(Paypage::class)->sendPaymentCode('all')
            ->sendTransaction('sale')
            ->sendCart(1, $this->total, 'test')
            ->sendCustomerDetails(
                $this->user->name,
                $this->user->email,
                $this->user->mobile,
                $this->address,
                $this->city,
                $this->country,
                'EG',
                35511,
                ip: request()->ip()
            )
            ->sendHideShipping(true)
            ->sendURLs("https://toot-sa.com/api/payment-callback/paytabs?order_id=".$this->order->id, "https://toot-sa.com/api/payment-callback/paytabs?order_id=".$this->order->id)
            ->sendLanguage('en')
            ->create_pay_page();
         return $pay->getTargetUrl();
    }
}
