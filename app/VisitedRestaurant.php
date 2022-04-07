<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitedRestaurant extends Model
{
    use HasFactory;
    public $protected =false; 

    protected $fillable = ['employee_id','restaurant_id','visit_date_time','feedback','meeting_date_time'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
