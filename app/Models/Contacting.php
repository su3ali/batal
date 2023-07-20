<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacting extends Model
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
            return $this->desc_ar;
        }else{
            return $this->desc_en;
        }
    }


    public function getimagesAttribute(){

        if ($this->image == null || \File::exists(public_path($this->image)) == false){
            return '';
        }

        $image = explode('/',$this->image);
        $name = end($image);

        $image = "data:image/png;base64,".base64_encode(file_get_contents(public_path("storage/images/contact/".$name)));

        return $image;
    }

    public function category(){
        return $this->hasOne(Category::class, 'id','category_id');
    }


}
