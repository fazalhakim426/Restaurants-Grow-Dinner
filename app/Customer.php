<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function user(){
        return $this->morphOne(User::class,'userable');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    
    public function customer_coupons()
    {
        return $this->hasMany(CustomerCoupon::class);
    }
    // public function coupons()
    // {
    //     return $this->hasManyThrough(
    //         CustomerCoupon::class,
    //         Coupon::class
    //     );
    // }
 
    public function bookedTable()
    {
        return $this->hasMany(BookedTable::class);
    }
    public function whishList()
    {
        return $this->hasMany(WhishList::class);
    }

    protected $fillable = [
        'dob','latitude','longitude'
    ];
}
