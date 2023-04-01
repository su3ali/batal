<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getNameAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->name_ar;
        }else{
            return $this->name_en;
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
