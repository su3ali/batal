<?php

namespace App\Http\Resources\Technician\home;

use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Order\StatusResource;
use App\Http\Resources\Service\ServiceByCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\User\UserResource;
use App\Models\VisitsStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class CancelReasonsResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'reason' => $this->reason
        ];
    }
}
