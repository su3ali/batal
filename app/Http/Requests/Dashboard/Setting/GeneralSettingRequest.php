<?php

namespace App\Http\Requests\Dashboard\Setting;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_name_ar'=>'required',
            'site_name_en'=>'required',
            'google_api_key' => 'nullable',
            'logo'=>'nullable|max:5120',
            'phone'=>'nullable',
            'whats_app'=>'nullable',
            'email'=>'nullable',
            'term_ar'=>'nullable|string|min:3',
            'term_en'=>'nullable|string|min:3',
            'privacy_ar'=>'nullable|string|min:3',
            'privacy_en'=>'nullable|string|min:3',
            'resting_start_time'=>'nullable',
            'resting_end_time'=>'nullable',
            'is_resting'=>'nullable|in:on,off',
            //            'reports_logo'=>'mimes:png|dimensions:max_width=100,max_height=100',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Website name',
        ];
    }
}
