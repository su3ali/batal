<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerComplaint extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,  'user_id');
    }
    public function customerComplaintImages()
    {
        return $this->hasMany(CustomerComplaintImage::class,  'customer_complaints_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,  'order_id');
    }
}
