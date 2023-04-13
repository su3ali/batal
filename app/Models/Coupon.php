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
}
