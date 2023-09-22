<?php

namespace App\Http\Resources\Intro;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class IntrosResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->getImageAttribute(),
        ];
    }
}
