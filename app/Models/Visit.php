<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function group(){
        return $this->belongsTo(Group::class, 'assign_to_id');
    }

    public function booking(){
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function status(){
        return $this->belongsTo(VisitsStatus::class, 'visits_status_id');
    }
    public function cancelReason(){
        return $this->belongsTo(ReasonCancel::class, 'reason_cancel_id');
    }
}
