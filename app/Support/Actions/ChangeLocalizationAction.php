<?php

namespace App\Support\Actions;

use App\Models\Language;
use Illuminate\Support\Facades\App;

class ChangeLocalizationAction
{
    public function __invoke($code)
    {
        $language = Language::where('code', $code)->firstOrFail();
        if ($language) {
            session()->put('locale', $code);
            session()->put('rtl', $language['rtl']);
            app()->setLocale($code);
        }
        return redirect()->back();
    }
}
