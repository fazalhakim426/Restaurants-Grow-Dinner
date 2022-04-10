<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedTable extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'table_id',
        'date',
        'time_slot',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
