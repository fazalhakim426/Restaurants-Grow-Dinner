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
        return [
            'id'            => $this->id,
            'user'          => new UserResource($this->user), 
            'salary'        => $this->salary, 
            'social_nr'     => $this->social_nr,
            'department'    => $this->department->name,
            'bank_account'  => $this->bank_account,
            'documents'     => env('APP_URL').'/'. $this->documents, 
            'verified'      => $this->email_verified_at || $this->phone_verified_at?true:false,  
        ];
    }
}
