<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model  
{
    use HasFactory;
    public $appends = ['expired','active'];

    protected $fillable = ['promo_code','start_at','end_at','amount','min_amount','is_fixed'];

    public function getExpiredAttribute()
    {
        $now = strtotime(now());  
        return  $now > strtotime($this->end_at);
  
     }

     public function getActiveAttribute()
    {
        $now = strtotime(now());  
         
        return $now > strtotime($this->start_at) && $now <strtotime($this->end_at);
    } 
      
}
