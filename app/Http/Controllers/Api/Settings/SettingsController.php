<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Faqs\FaqResource;
use App\Http\Resources\Setting\SettingResource;
use App\Models\CustomerWallet;
use App\Models\Faq;
use App\Models\Setting;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function index(){
        $this->body['settings'] = SettingResource::make(Setting::query()->first());
        return self::apiResponse(200, '', $this->body);
    }

    protected function getFaqs(){
        $this->body['faqs'] = FaqResource::collection(Faq::query()->where('active',1)->get());
        return self::apiResponse(200, '', $this->body);
    }


    protected function walletDetails(){
        $user = auth()->user('sanctum');
        $walletSetting = CustomerWallet::query()->first();
        $data = [
            'wallet' => $user->point,
            'order_amount' => $walletSetting->order_amount,
            'wallet_amount' => $walletSetting->wallet_amount,
        ];
        $this->body['walletDetail'] = $data;
        return self::apiResponse(200, '', $this->body);
    }
}

