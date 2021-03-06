<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return
        [
            'id'    => $this->id,
            'created_at'    => $this->created_at->diffForHumans(),
            'stars'         => $this->stars,
            'feedback'      => $this->feedback,
            'restaurant_id' => $this->restaurant_id,
            'customer'   => new CustomerResource($this->customer()->with('user')->first()),
        ];
    }
}
