<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VisitedRestaurantRersource;
class RestaurantResource extends JsonResource
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
            'id'=> $this->id,
            'first_name'=> $user->first_name,
            'email'=> $user->email,
            'phone'=> $user->phone,  
            'country'=> $user->country,
            'verified'=> $user->varified_at?true:false,
            "closing_time" => $this->closing_time,
            "opening_time" => $this->opening_time, 
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "description" => $this->description,
            "photo" => $this->photo,
            "menu" => $this->menu,
            "instagram_link" => $this->instagram_link,
            "facebook_link" => $this->facebook_link,
            "twiter_link" => $this->twiter_link,
            "website_link" => $this->website_link,
            "informational_tags" => $this->informational_tags,
            "created_at" => $this->created_at,  
            'category' =>  $this->category,
            'visited_restaurant'=> new VisitedRestaurantRersource($this->visited_restaurant),
        ];
    }
}
