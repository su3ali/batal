<?php

namespace App\Http\Resources\Checkout;

use App\Http\Resources\service\AdditionsResource;
use App\Models\Addition;
use App\Models\ContractPackage;
use App\Models\ContractPackagesUser;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = [];
        if ($this->service) {
            foreach ($this->service->serviceImages as $serviceImage) {
                if ($serviceImage->image) {
                    $images[] = asset($serviceImage->image);
                }
            }
        }


        $contractPackagesUser =  ContractPackagesUser::where('user_id', auth()->user()->id)->where('contract_packages_id', $this->contract_package_id)->first();

        $tempTotal = ($this->price * $this->quantity);
        if ($contractPackagesUser) {
            
            $contractPackage = ContractPackage::where('id', $contractPackagesUser->contract_packages_id)->first();
            if ($this->quantity <  ($contractPackage->visit_number - $contractPackagesUser->used)) {
                $tempTotal = 0;
            } else {
                $tempTotal = ($this->quantity - ($contractPackage->visit_number - $contractPackagesUser->used)) * $this->price;
            }
        }

        return [
            'id' => $this->id,
            'service_id' => $this->service_id??0,
            'category_id' => $this->service?->category->id??0,
            'category_title' => $this->service?->category->title??'',
            'service_title' => $this->service?->title??'',
            'quantity' => $this->quantity,
            'service_image' => $images,
            'price' => $tempTotal,
            'package_id' => $this->contract_package_id,
            'type' => $this->type,
            'package_name' => $this->type == 'package' ? $this->package->name : null
        ];
    }
}
