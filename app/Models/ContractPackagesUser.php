<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPackagesUser extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function contactPackage()
    {
        return $this->belongsTo(ContractPackage::class, 'contract_packages_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,  'user_id');
    }
}
