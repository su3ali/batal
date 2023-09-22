<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'id', 'order_id');
    }

}
