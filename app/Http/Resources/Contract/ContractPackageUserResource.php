<?php

namespace App\Http\Resources\Contract;


use App\Models\ContractPackage;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractPackageUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->from == 'MyContractPackages') {
            $packages = [];
            $group = $this;
            for ($i = 0; $i < $group->count(); $i++) {

                $curr = $group[$i];

                $package = ContractPackage::where('id',  $curr->contract_packages_id)->first();

                $endDate = Carbon::parse($curr->end_date)->timezone('Asia/Riyadh');
                $now = Carbon::now('Asia/Riyadh');
                $packages[] = [
                    'id' => $curr->id,
                    'used' => $curr->used,
                    'end_date' => $curr->end_date,
                    'remaning_days' => $now->diffInDays($endDate),
                    'user_id' =>  $curr->user_id,
                    'contract_packages_id' =>  $curr->contract_packages_id,
                    'contract_package' => ContractResource::make($package),
                ];
            }
            return  $packages;
        } else {
            $curr = $this[0];
            $package = ContractPackage::query()->where('id',  $curr->contract_packages_id)->first();
            $endDate = Carbon::parse($curr->end_date)->timezone('Asia/Riyadh');
            $now = Carbon::now('Asia/Riyadh');
            return [
                'id' => $curr->id,
                'used' => $curr->used,
                'end_date' => $curr->end_date,
                'remaning_days' => $now->diffInDays($endDate),
                'user_id' =>  $curr->user_id,
                'contract_packages_id' =>  $curr->contract_packages_id,
                'contract_package' => ContractResource::make($package),
            ];
        }
    }
}
