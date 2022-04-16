<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhishList extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','restaurant_id'];
    public $timestamps = false;
    public function restaurant(){
        return $this->hasOne(Resturants::class);
    }
    
    public function customer(){
        return $this->hasOne(Customer::class);
    }
}
