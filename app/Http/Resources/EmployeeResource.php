<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CountryResource;
class EmployeeResource extends JsonResource
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
            'salary'=> $this->salary, 
            'social_nr'=> $this->social_nr,
            'department'=> $this->department->name,
            'bank_account'=> $this->bank_account,
            'documents'=> env('APP_URL').'/'. $this->documents,
            'first_name'=> $user->first_name,
            'last_name'=> $user->last_name,  
            'country'=>new CountryResource($user->country), 
            'address'=> $user->address,  
            'email'=> $user->email,  
            'phone'=> $user->phone,  
             'verified' => $this->email_verified_at || $this->phone_verified_at?true:false,
            
        ];
    }
}
