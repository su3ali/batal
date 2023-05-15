<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonCancel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getReasonAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->reason_ar;
        }else{
            return $this->reason_en;
        }
    }

}
