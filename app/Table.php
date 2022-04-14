<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['restaurant_id','name','number','description','photo','min_person','max_person'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function bookedTables()
    {
        return $this->hasMany(BookedTable::class);
    }
    
    public function getAllTimeSlotsAttribute()
    {
        $interval = 30*60;
        $restaurant = $this->restaurant;
        $from = $restaurant->opening_time;
        $to = $restaurant->closing_time;  
        $from = strtotime($from);
        $to = strtotime($to);
        $slots= array(); 

        while($from<$to){
           array_push($slots,date('H:i',$from).' - '. date('H:i',$from+$interval));
           $from = $from+$interval; 
        }
        return $slots;
    }
   

}
