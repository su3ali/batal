<?php

namespace App\Http\Resources\Contract;

use App\Http\Resources\Service\IconResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\ContractPackagesService;
use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $services_ids = ContractPackagesService::where('contract_packages_id', $this->id)->pluck('service_id');

        for ($i = 0; $i < $services_ids->count(); $i++) {

            $service = Service::where('id', $services_ids[$i])->first();

            $services[] = [
                'service_icons' => IconResource::collection($service->icons),
                'service' => ServiceResource::make($service),
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'visit_number' => $this->visit_number,
            'image' => asset($this->image),
            'services' => $services,
        ];
    }
}
