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
            'user'=> $user?new UserResource($user):null, 
            'dob'=> $this->dob,  
            'longitude' => $this->longitude,
            'latitude' => $this->latitude, 

             'verified' => $this->email_verified_at || $this->phone_verified_at?true:false,
            
        ];
    }
}
