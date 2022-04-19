<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{ 
    public $timestamps = false;

    protected $fillable = [ 
        "name", 
        "active",
        'icon',
    ];
    
    public function resturants()
    {
        return $this->hasMany(Restaurant::class);
    }
}
