<?php

namespace App\Models;

use App\Support\Traits\HasPassword;
use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens,WithBoot,HasPassword, HasFactory,HasRoles, Notifiable;
    protected $guard = 'user';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'active',
        'city_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }



}
