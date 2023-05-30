<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'site_name_ar' => $this->site_name_ar,
            'site_name_en' => $this->site_name_en,
            'logo' => asset($this->logo),
            'email' => $this->email,
            'phone' => $this->phone,
            'whats_app' => $this->whats_app,
            'term_ar' => $this->term_ar,
            'term_en' => $this->term_en,
            'privacy_ar' => $this->privacy_ar,
            'privacy_en' => $this->privacy_en,
        ];
    }

}
