<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
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


    public function getimageAttribute(){

        if ($this->slug == null || \File::exists(public_path($this->slug)) == false){
            return '';
        }

        $image = explode('/',$this->slug);
        $name = end($image);

        $image = "data:image/png;base64,".base64_encode(file_get_contents(public_path("storage/images/category/".$name)));

        return $image;
    }
    public function services(){
        return $this->hasMany(Service::class, 'category_id');
    }

    public function groups(){
        return $this->belongsToMany(Group::class, 'category_groups');
    }


}
