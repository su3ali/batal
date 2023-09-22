<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
    public function contract(){
        return $this->hasOne(Contract::class, 'id', 'service_id');
    }
    public function status(){
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }
    public function bookings(){
        return $this->hasMany(Booking::class, 'order_id');
    }
    public function services(){
        return $this->belongsToMany(Service::class, 'order_services')->withPivot(['price', 'quantity']);
    }

    public function transaction(){
        return $this->hasOne(Transaction::class, 'order_id', 'id');
    }
    public function order_payment(){
        return $this->hasOne(OrderPayment::class, 'id', 'order_id');
    }

}
