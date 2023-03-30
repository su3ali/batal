<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
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


    public function serviceImages()
    {
        return $this->hasMany(ServiceImages::class,'service_id','id');
    }

}
