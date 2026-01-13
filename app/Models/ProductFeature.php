<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    protected $fillable = [
        'product_id',
        'roast_level',
        'country'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
