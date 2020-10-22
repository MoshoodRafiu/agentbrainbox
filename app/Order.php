<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'transaction_id',
        'user_id',
        'merchant_id',
        'shopping_row_id',
        'tracking_id',
        'order_status',
        'location',
        'order_total',
        'user_has_received_order'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
