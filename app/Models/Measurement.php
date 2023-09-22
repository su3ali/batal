<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
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
    public function getSymbolAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->symbol_ar;
        }else{
            return $this->symbol_ar;
        }
    }
}
