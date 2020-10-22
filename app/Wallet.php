<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'merchant_id',
        'balance',
        'history',
        'pending_withdrawal_requests'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
