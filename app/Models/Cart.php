<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
    public function package()
    {
        return $this->hasOne(ContractPackage::class, 'id', 'contract_package_id');
    }
    public function coupon(){
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }
}
