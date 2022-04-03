<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCoupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'coupen_id', 'customer_id'
    ];
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }
}
