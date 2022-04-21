<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'min_person'  => $this->min_person,
            'max_person'  => $this->max_person,
            'number'      => $this->number,
            'description' => $this->description,
            'photo'       => env('APP_URL').'/'.$this->photo, 
            'resturant'   => $this->restaurant,

        ];
    }
}
