<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
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

    public function package(){
        return $this->hasOne(ContractPackage::class, 'id', 'package_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function bookings(){
        return $this->hasMany(Booking::class, 'contract_order_id');
    }
}
