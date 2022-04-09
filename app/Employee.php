<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use App\User;

use function PHPSTORM_META\map;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['salary','department_id','social_nr','bank_account','documents'];
    
    public function user(){
        return $this->morphOne(User::class,'userable');
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function visited_restaurants()
    {
        return $this->hasMany(VisitedRestaurant::class);
    } 
    public function restaurants(){
        return  $this->visited_restaurants
                     ->map(function($visited_restaurants)
                     {
                            return $visited_restaurants->restaurant;
                     });
         
    }
    
}
