<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewDetailsResource extends JsonResource
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
                'rating' => $this->reviews()->avg('stars'),
                'total' =>$this->reviews()->count(),
                '5' => $this->reviews()->where('stars',5)->count(),
                '4' => $this->reviews()->where('stars',4)->count(),
                '3' => $this->reviews()->where('stars',3)->count(),
                '2' => $this->reviews()->where('stars',2)->count(),
                '1' => $this->reviews()->where('stars',1)->count(),
                'reviews' => ReviewResource::collection($this->whenLoaded('reviews')), 
           
        ];
        
    }
}
