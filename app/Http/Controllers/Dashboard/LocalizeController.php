<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LocalizeController extends Controller
{
    protected function changeLocale($code){
        $language = Language::where('code', $code)->firstOrFail();
        if ($language) {
            session()->put('locale', $code);
            session()->put('rtl', $language['rtl']);
            app()->setLocale($code);
        }
        return redirect()->back();
    }
}
