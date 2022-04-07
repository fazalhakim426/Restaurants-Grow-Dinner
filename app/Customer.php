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
    
    public function coupons()
    {
        return $this->hasMany(Coupen::class);
    }

    public function whishList()
    {
        return $this->hasMany(WhishList::class);
    }
    protected $fillable = [
        'dob','latitude','longitude'
    ];
}
