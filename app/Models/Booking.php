<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'time' => 'timestamp',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id','id');
    }
    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_order_id','id');
    }
    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function service(){
        return $this->hasOne(Service::class, 'id','service_id');
    }
    public function package(){
        return $this->hasOne(ContractPackage::class, 'id','package_id');
    }
    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function booking_status(){
        return $this->hasOne(BookingStatus::class, 'id','booking_status_id');
    }
    public function booking_setting(){
        return $this->hasOne(BookingStatus::class, 'id','booking_status_id');
    }

    public function address(){
        return $this->hasOne(UserAddresses::class,'id', 'user_address_id');
    }
    public function visit(){
        return $this->hasOne(Visit::class);
    }
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
