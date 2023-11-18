<?php

namespace App\Http\Resources\Complaint;

use App\Http\Resources\Order\OrderResource;
use App\Models\CustomerComplaint;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $customerComplaint = CustomerComplaint::query()->find($this['id']);

        $images = [];
        foreach ($this->customerComplaintImages as $customerComplaintImage) {
            if ($customerComplaintImage->image) {
                $images[] = asset($customerComplaintImage->image);
            }
        }
        return [
            'id' => $this->id,
            'text' => $this->text,
            'images' => $images,
            'video' => $this->video,
            'order' => OrderResource::make($this->order),
        ];
    }
}
