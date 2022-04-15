<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCoupon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'coupon_id', 'customer_id'
    ];
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }


}
