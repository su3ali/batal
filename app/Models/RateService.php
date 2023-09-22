<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateService extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function order(){
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
