<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'charges',
        'total',
        'has_delivered'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
