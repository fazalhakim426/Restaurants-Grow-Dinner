<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name','city_id'];
    public $timestamps = false;
     
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
