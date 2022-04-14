<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedTable extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'table_id',
        'date',
        'time_slot',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function customer()
    {
        return $this->belongsToMany(Customer::class);
    }
}
