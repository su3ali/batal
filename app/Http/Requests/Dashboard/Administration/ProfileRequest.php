<?php

namespace App\Http\Requests\Dashboard\Administration;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:admins,email,' . request()->route('profile'),
            'phone' => 'required|numeric|unique:admins,phone,' . request()->route('profile'),
            'password' => ['nullable', 'confirmed', Password::min(4)],
            'avatar' => 'nullable|image',
            'active' => 'nullable',
        ];
        return $rules;
    }
}
