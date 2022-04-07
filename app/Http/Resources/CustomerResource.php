<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->user; 
        return [
            'id'=>$this->id,
            'dob'=> $this->dob, 
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'first_name'=> $user->first_name,
            'last_name'=> $user->last_name,  
            'country'=> $user->country,
            'address'=> $user->address,  
            'email'=> $user->email,  
            'verified' => $user->verified_at?true:false
        ];
    }
}
