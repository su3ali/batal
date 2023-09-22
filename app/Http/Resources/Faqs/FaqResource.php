<?php

namespace App\Http\Resources\Faqs;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'question'  => $this->Q,
            'answer'  => $this->Ans,
        ];
    }

}
