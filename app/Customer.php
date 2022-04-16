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
     
 
    public function bookedTable()
    {
        return $this->hasMany(BookedTable::class);
    }
  
    public function whishLists()
    {
        return $this->belongsToMany(Restaurant::class,'whish_lists');
    }


    protected $fillable = [
        'dob','latitude','longitude'
    ];
}
