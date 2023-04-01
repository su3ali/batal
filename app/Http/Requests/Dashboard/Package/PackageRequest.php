<?php

namespace App\Http\Requests\Dashboard\Package;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    use ValidationRequest;


    public function rules()
    {
        return [
            'price' => 'numeric|nullable',
            'title' => 'array',
            'title.*' => 'nullable|string|min:2',
            'description' => 'array',
            'description.*' => 'nullable|string|min:2',
            'image' => 'image',
        ];
    }


}
