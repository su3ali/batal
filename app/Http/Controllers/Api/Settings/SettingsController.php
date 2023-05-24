<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\SettingResource;
use App\Models\Setting;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function index(){
        $this->body['settings'] = SettingResource::make(Setting::query()->first());
        return self::apiResponse(200, '', $this->body);
    }
}
