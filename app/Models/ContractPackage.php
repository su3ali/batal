<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPackage extends Model
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


    public function getAvaterAttribute(){

        if ($this->image == null || \File::exists(public_path($this->image)) == false){
            return '';
        }

        $image = explode('/',$this->image);
        $name = end($image);

        $image = "data:image/png;base64,".base64_encode(file_get_contents(public_path("storage/images/contract_packages/".$name)));

        return $image;
    }

    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
