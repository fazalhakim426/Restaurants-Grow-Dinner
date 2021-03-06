<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookedTableResource extends JsonResource
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
            'id'         => $this->id,
            'time_slot'  => $this->time_slot,   
            'date'       => $this->date,
            'created_at_for_hummans' => $this->created_at->diffForHumans(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at->diffForHumans(),
            'table'      => new TableResource($this->table), 
            'customer'  => new CustomerResource($this->whenLoaded('customer')),
        ]; 
       }}