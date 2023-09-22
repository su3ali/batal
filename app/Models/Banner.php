<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getTitleAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->title_ar;
        }else{
            return $this->title_en;
        }
    }

    public function getslugAttribute(){

        if ($this->image == null || \File::exists(public_path($this->image)) == false){
            return '';
        }

        $image = explode('/',$this->image);
        $name = end($image);

        $image = "data:image/png;base64,".base64_encode(file_get_contents(public_path("storage/images/banners/".$name)));

        return $image;
    }

    public function bannerImages()
    {
        return $this->hasMany(BannerImage::class,'banner_id','id');
    }


}
