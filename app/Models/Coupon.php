<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
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
    public function getDescriptionAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->description_ar;
        }else{
            return $this->description_en;
        }
    }

    public function getavatarAttribute(){

        if ($this->image == null || \File::exists(public_path($this->image)) == false){
            return '';
        }

        $image = explode('/',$this->image);
        $name = end($image);

        $image = "data:image/png;base64,".base64_encode(file_get_contents(public_path("storage/images/coupons/".$name)));

        return $image;
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
