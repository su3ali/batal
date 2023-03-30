<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


trait imageTrait{

    function storeImages($photo, $dir): string
    {
        $file_extintion=$photo->getClientOriginalExtension();
        $file_name=time().rand(15,100).'.'.$file_extintion;
        $photo->move(storage_path('app/public/images/'.$dir.'/'), $file_name);

        return $file_name;
    }

}
