<?php

namespace App\Http\Resources\Technician\lang;

use App\Http\Resources\Service\ServiceByCategoryResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class LangResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'flag' => $this->flag,
            'direction' => $this->direction,
            'sort' => $this->sort,
            'active' => $this->active,

        ];
    }
}
