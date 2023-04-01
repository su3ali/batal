<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\GeneralSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected function index(){
        $settings = Setting::query()->first();
        return view('dashboard.settings.index', get_defined_vars());
    }
    protected function update(GeneralSettingRequest $request){
        Setting::query()->first()->update($request->validated());
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
}
