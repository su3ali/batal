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
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function service(){
        return $this->hasOne(Service::class, 'id','service_id');
    }
    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function booking_status(){
        return $this->hasOne(BookingStatus::class, 'id','booking_status_id');
    }
}
