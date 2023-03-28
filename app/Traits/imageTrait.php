<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


trait imageTrait{

    function storeImages($photo){
        $file_extintion=$photo->getClientOriginalExtension();
        $file_name=time().rand(15,100).'.'.$file_extintion;

        $img = Image::make($photo->getRealPath());
        Storage::disk('local')->put('public/images/category'.'/'.$file_name, $img, 'public');

        return $file_name;
    }

}
