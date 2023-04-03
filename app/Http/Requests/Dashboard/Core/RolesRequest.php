<?php

namespace App\Http\Requests\Dashboard\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
{
    use ValidationRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

    }
}
