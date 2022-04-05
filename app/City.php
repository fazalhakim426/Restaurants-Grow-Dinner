<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
   protected $fillable = [
       'name','country_id'
   ];


    public function department(){
        return $this->hasMany(Departments::class);
    }
}
