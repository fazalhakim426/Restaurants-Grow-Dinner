<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
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
}
