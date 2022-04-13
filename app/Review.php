<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['stars','feedback','restaurant_id','customer_id' ];
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
