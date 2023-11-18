<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerComplaintImage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customerComplaint()
    {
        return $this->belongsTo(CustomerComplaint::class,  'customer_complaints_id');
    }
}
