<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\GeneralSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    protected function index(){
        $settings = Setting::query()->first();
        return view('dashboard.settings.index', get_defined_vars());
    }
    protected function update(GeneralSettingRequest $request){
        $setting = Setting::query()->first();
        $validated = $request->validated();

        if ($request->hasFile('logo')) {

            if (File::exists(public_path($setting->logo))) {
                File::delete(public_path($setting->logo));
            }
            $image = $request->file('logo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->logo->move(storage_path('app/public/images/setting/'), $filename);
            $validated['logo'] = 'storage/images/setting'.'/'. $filename;
        }

        if ($request['is_resting'] && $request['is_resting'] == 'on') {
            $validated['is_resting'] = 1;
        } else {
            $validated['is_resting'] = 0;
        }

        $setting->update($validated);
        return redirect()->back()->with('success', __('dash.successful_operation'));
    }
}
