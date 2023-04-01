<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\CustomerWallet;
use Illuminate\Http\Request;


class CustomerWalletController extends Controller
{
    protected function index(){
        $wallet = CustomerWallet::query()->first();
        return view('dashboard.core.customer_wallet.index', compact('wallet'));
    }
    protected function store(Request $request){
        $request->validate([
            'name_ar' => 'required|String|min:3',
            'name_en' => 'required|String|min:3',
            'active' => 'nullable|in:on,off',
            'order_percentage' => 'required|numeric',
            'refund_amount' => 'required|numeric',
            'order_amount' => 'required|numeric',
            'wallet_amount' => 'required|numeric',
        ]);

        $data=$request->except('_token','active');

        if ($request['active'] && $request['active'] == 'on'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }

        CustomerWallet::query()->create($data);
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
    protected function update(Request $request){
        $request->validate([
            'name_ar' => 'required|String|min:3',
            'name_en' => 'required|String|min:3',
            'active' => 'nullable|in:on,off',
            'order_percentage' => 'required|numeric',
            'refund_amount' => 'required|numeric',
            'order_amount' => 'required|numeric',
            'wallet_amount' => 'required|numeric',
        ]);


        $data=$request->except('_token','active');

        if ($request['active'] && $request['active'] == 'on'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }

        CustomerWallet::query()->first()->update($data);
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
}
