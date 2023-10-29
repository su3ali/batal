<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Version;
use App\Support\Api\ApiResponse;

class VersionController extends Controller
{
    use ApiResponse;

    protected function checkUpdate(Request $request)
    {
        $rules = [
            'os' => 'required',
            'version' => 'required',
        ];
        $request->validate($rules, $request->all());
        $version = Version::where('os', $request->os)->first();
        if ($version->version == $request->version) {
            $this->body['allowed'] = 1;
            return self::apiResponse(200, __('api.allowed'), $this->body);
        } else {
            $this->body['allowed'] = 0;
            return self::apiResponse(200, __('api.Notallowed'), $this->body);
        }
    }
}
