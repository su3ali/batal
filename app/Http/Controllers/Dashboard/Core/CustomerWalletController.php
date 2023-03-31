<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\CustomerWallet;
use Illuminate\Support\Facades\Request;


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
        ]);
        CustomerWallet::query()->first()->update();
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
    protected function update(Request $request){
        $request->validate([
            'file' => 'required',
            'service_id' => 'required',
        ]);
        CustomerWallet::query()->first()->update();
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
}
