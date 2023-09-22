<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\CustomerWallet;
use App\Models\TechnicianWallet;
use Illuminate\Http\Request;


class TechnicianWalletController extends Controller
{
    protected function index(){
        $wallet = TechnicianWallet::query()->first();
        return view('dashboard.core.technician_wallet.index', compact('wallet'));
    }
    protected function store(Request $request){
        $request->validate([
            'name_ar' => 'required|String|min:3',
            'name_en' => 'required|String|min:3',
            'point_type' => 'nullable|in:rate,fixed',
            'price' => 'required|numeric',
            'calculation_method' => 'nullable|in:bill,service',
        ]);

        $data=$request->except('_token');



        TechnicianWallet::query()->create($data);
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
    protected function update(Request $request){
        $request->validate([
            'name_ar' => 'required|String|min:3',
            'name_en' => 'required|String|min:3',
            'point_type' => 'nullable|in:rate,fixed',
            'price' => 'required|numeric',
            'calculation_method' => 'nullable|in:bill,service',
        ]);


        $data=$request->except('_token');

        TechnicianWallet::query()->first()->update($data);
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
}
