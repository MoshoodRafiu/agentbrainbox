<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = [
        'business_name',
        'business_email',
        'business_phone',
        'contact_verification',
        'business_image',
        'country',
        'state',
        'city',
        'business_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallets()
    {
        return $this->hasOne(Wallet::class);
    }
}
