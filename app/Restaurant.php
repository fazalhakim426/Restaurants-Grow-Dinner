<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Restaurant extends Model
{
    use HasFactory;
    protected $appends = ['rating'];
    protected $fillable = [
        'category_id',
        'closing_time',
        'opening_time',
        'longitude',
        'latitude',
        'description', 'name',
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

    public function bookedTables()
    {
        return $this->hasManyThrough(
            BookedTable::class,
            Table::class, //enviroment
            'restaurant_id', // Foreign key on the environments table...
            'table_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }
    public function getRatingAttribute()
    {
        return $this->reviews()->avg('stars');
    }
    //distance against login customer
    public function getCustomerDistanceAttribute()
    {
        $customer = Auth::user()->userable;
        $latitude = $customer->latitude;
        $longitude = $customer->longitude;
        if (!$latitude || !$longitude)
            return null;
        return 3959 * acos(
            cos(deg2rad($latitude))
                * cos(deg2rad($this->latitude))
                * cos(deg2rad($this->longitude) - deg2rad($longitude))
                + sin(deg2rad($latitude))
                * sin(deg2rad($this->latitude))
        );
    } 
    //liked against login customer
    public function getLikedAttribute()
    {
        return WhishList::where('customer_id', Auth::user()->userable_id)->where('restaurant_id', $this->id)->first() ? true : false;
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    } 
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function visited_restaurant()
    {
        return $this->hasOne(VisitedRestaurant::class);
    }
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
