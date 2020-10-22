<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'path',
        'thumbnail_path'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
