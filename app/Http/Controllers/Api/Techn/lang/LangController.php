<?php

namespace App\Http\Controllers\Api\Techn\lang;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Technician\home\VisitsResource;
use App\Http\Resources\Technician\lang\LangResource;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Group;
use App\Models\Language;
use App\Models\Order;
use App\Models\User;
use App\Models\Visit;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LangController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function getLang()
    {
        $langs = Language::where('active',1)->get();
        $this->body['lang'] = LangResource::collection($langs);
        return self::apiResponse(200, null, $this->body);
    }



}
