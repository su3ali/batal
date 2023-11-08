<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPackagesService extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function contactPackage()
    {
        return $this->belongsTo(ContractPackage::class, 'contract_packages_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
