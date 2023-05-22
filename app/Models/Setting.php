<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];


    public function getimageAttribute(){

        if ($this->logo == null || \File::exists(public_path($this->logo)) == false){
            return '';
        }

        $image = explode('/',$this->logo);
        $name = end($image);

        $image = "data:image/png;base64,".base64_encode(file_get_contents(public_path("storage/images/setting/".$name)));

        return $image;
    }
}
