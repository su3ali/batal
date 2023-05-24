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
        ];
    }

}
