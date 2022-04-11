<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    
    protected $fillable = ['title','longitude','latitude','address','customer_id'];
    public $timestamps = false;
    public function customer()
    {
        return $this->belongsTo(Customer::class); 
    }
}
