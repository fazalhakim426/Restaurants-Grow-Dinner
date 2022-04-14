<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'active' => $this->active,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'country' => new CountryResource($this->country),
            'email' => $this->email,
            'phone' => $this->phone,
            'verified' => $this->email_verified_at || $this->phone_verified_at?true:false,
            'userable' => $this->whenLoaded('userable'),  
            'userable_type' => $this->userable_type,  
            'userable_id' => $this->userable_id,  
        ];
    }
}
