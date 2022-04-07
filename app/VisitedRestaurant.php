<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitedRestaurant extends Model
{
    use HasFactory;
    public $timestamps =false; 

    protected $fillable = ['employee_id','restaurant_id','visited_at','feedback'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
