<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Restaurant extends Model
{
    use HasFactory;
    // protected $appends = ['distance'];
    protected $fillable = ['category_id',
                            'closing_time',
                            'opening_time',
                            'longitude',
                            'latitude',
                            'description','name',
                            'photo',
                            'menu',
                            'instagram_link',
                            'facebook_link',
                            'website_link',
                            'informational_tags',
                            'twitter_link'
                           ]; 
    public function category()
    {
        return $this->belongsTo(Category::class);
    } 
    
    public function user(){
        return $this->morphOne(User::class,'userable');
    }

    public function visited_restaurant(){
         return $this->hasOne(VisitedRestaurant::class);
    }
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
    // public function getDistanceAttribute()
    // {
    //     $auth_user =  Auth::user();
    //     return  $this->distance($auth_user->userable->latitude,
    //     $auth_user->userable->longitude,
        
    //     $this->latitude,$this->longitude,'M');
    // }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
   } 
}
