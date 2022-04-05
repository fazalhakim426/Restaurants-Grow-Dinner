<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $fillable = ['id'];
    public function user(){
        return $this->morphOne(User::class,'userable');
    }
}
