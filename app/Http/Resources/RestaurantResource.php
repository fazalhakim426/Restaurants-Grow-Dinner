<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VisitedRestaurantRersource;
use Illuminate\Support\Facades\Auth;

class RestaurantResource extends JsonResource
{
 
    public function toArray($request)
    {  
        $user = $this->user;   
        return [
            'id'            => $this->id,
            'liked'         => $this->liked,
            'active'        => $this->user->active, 
            'first_name'    => $user->first_name,
            'email'         => $user->email,
            'phone'         => $user->phone,  
            'address'       => $user->address,  
            'country'       => $user->country, 
            'verified'      => $user->varified_at?true:false,
            "opening_time"  => date('h:i A', strtotime( $this->opening_time)), 
            "closing_time"  => date('h:i A', strtotime($this->closing_time)),
            "distance"      => $this->distance?$this->distance:$this->customer_distance,
            "latitude"      => $this->latitude,
            "longitude"     => $this->longitude,
            "description"   => $this->description,
            "photo"         => env('APP_URL').'/'.$this->photo,
            "menu"          =>  env('APP_URL').'/'.$this->menu,
           "instagram_link" => $this->instagram_link,
            "facebook_link" => $this->facebook_link,
            "twitter_link"  => $this->twitter_link,
            "website_link"  => $this->website_link,
            "created_at"    => $this->created_at,  
            'category'      => $this->category,  
            'review_details'=> new ReviewDetailsResource($this),
            "informational_tags" => $this->informational_tags,
            'visited_restaurant' => new VisitedRestaurantRersource($this->whenLoaded('visited_restaurant')),
        ];
    }
}
