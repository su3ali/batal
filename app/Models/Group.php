<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getNameAttribute(){
        if (app()->getLocale()=='ar'){
            return $this->name_ar;
        }else{
            return $this->name_en;
        }
    }
    public function services(){
        return $this->belongsToMany(Service::class,'service_groups');
    }
    protected function leader(){
        return $this->hasOne(Technician::class, 'id','technician_id');
    }
    public function technicians(){
        return $this->hasMany(Technician::class);
    }

    public function technician_groups(){
        return $this->hasMany(GroupTechnician::class);
    }
    public function regions(){
        return $this->hasMany(GroupRegion::class);
    }
}
