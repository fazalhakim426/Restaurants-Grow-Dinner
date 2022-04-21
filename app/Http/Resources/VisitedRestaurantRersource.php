<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitedRestaurantRersource extends JsonResource
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
            'visited_at' => $this->visited_at,
            'type'       => strtotime(Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())) < strtotime($this->visited_at)?'Meeting':'Visited', 
            'feedback'   => $this->feedback,
            'attandance' => $this->attandance,
            'intrested'  => $this->intrested,
            'employee'   => new EmployeeResource($this->employee),
        ];
    }
}
