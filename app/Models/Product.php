<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'manufacturer',
        'price',
        'unit',
        'short_description',
        'description',
        'image_path'
    ];

    public function features()
    {
        return $this->hasMany(ProductFeature::class);   
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
