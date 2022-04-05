<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinanceResource extends JsonResource
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
            'first_name'=> $user->first_name,
            'last_name'=> $user->last_name, 
            'city'=> $user->city, 
            'country'=> $user->country, 
            'address'=> $user->address, 
            'phone'=> $user->phone,  
            'email'=> $user->email,  
            'verified' => ($user->email_verified_at || $user->phone_verified_at)?true:false
        ];
    }
}
