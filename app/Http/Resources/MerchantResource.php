<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "business_name" => $this->business_name,
            "business_email" => $this->business_email,
            "business_phone" => $this->business_phone,
            "contact_verification" => $this->contact_verification == 1,
            "business_image" => $this->business_image,
            "country" => $this->country,
            "state" => $this->state,
            "city" => $this->city,
            "business_address" => $this->business_address,
            "registered_on" => date('Y-m-d H:i:s', strtotime($this->created_at))
        ];
    }
}
