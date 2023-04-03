<?php

namespace App\Http\Requests\Dashboard\HomeSection;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class HomeSectionRequest extends FormRequest
{
    use ValidationRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|in:feature,about,footer,success_partners',
            'title'    => 'array',
            'title.*'  => 'nullable|string|min:2',
            'description'    => 'array',
            'description.*'  => 'nullable|string|min:2',
            'image'    => 'image',
        ];
    }


}
