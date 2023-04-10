<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getQAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->q_ar;
        }else{
            return $this->q_en;
        }
    }
    public function getAnsAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->ans_ar;
        }else{
            return $this->ans_en;
        }
    }
}
