<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'merchant_id',
        'category_id',
        'name',
        'model',
        'description',
        'specification',
        'other_details',
        'price',
        'is_new',
        'is_negotiable'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
