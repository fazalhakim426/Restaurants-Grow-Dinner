<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhishList extends Model
{
    use HasFactory;

    public function restaurant(){
        return $this->hasOne(Resturants::class);
    }
    
    public function customer(){
        return $this->hasOne(Customer::class);
    }
}
