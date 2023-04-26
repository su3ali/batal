<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Support\Traits\HasPassword;
use App\Support\Traits\WithBoot;
class Admin extends Authenticatable
{
    use HasApiTokens,WithBoot,HasPassword, HasFactory,HasRoles, Notifiable;
    protected $guard = 'dashboard';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'active',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];



}
