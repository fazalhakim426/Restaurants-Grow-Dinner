<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['restaurant_id','name','number','description','photo'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

}
