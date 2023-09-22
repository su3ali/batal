<?php

namespace App\Http\Resources\Technician\auth;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'id'  => $this->id,
            'user_name'  => $this->user_name,
            'name'  => $this->name,
            'image'  => asset($this->image),
            'email' => $this->email,
            'phone' => $this->phone,
            'fcm_token' => $this->fcm_token,
            'points' => $this->point,
        ];
    }
}
