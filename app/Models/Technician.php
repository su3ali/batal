<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function specialization(){
        return $this->hasOne(Specialization::class, 'id', 'spec_id');
    }


    public function group(){
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

}
