<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    } 
    
    public function user(){
        return $this->morphOne(User::class,'userable');
    }
}