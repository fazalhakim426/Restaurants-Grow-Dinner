<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'promo_code' => $this->promo_code,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'is_fixed'=> $this->is_fixed,
            'amount' => $this->amount,
            'active' => $this->active,
            'expired' => $this->expired,
        ];
    }
}
