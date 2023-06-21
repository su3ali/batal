<?php

namespace App\Models;

use App\Support\Traits\HasPassword;
use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Technician extends Authenticatable
{
    use HasApiTokens,HasPassword, HasFactory,HasRoles, Notifiable;
    protected $guard = 'technician';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function specialization(){
        return $this->hasOne(Specialization::class, 'id', 'spec_id');
    }


    public function group(){
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function rates(){
        return $this->hasMany(RateTechnician::class, 'technician_id', 'id');
    }

}
