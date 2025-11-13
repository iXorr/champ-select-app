<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'supplier_country',
        'product_type',
        'color',
        'description',
        'image_url',
        'stock',
        'sold',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, '', ' ') . ' ₽';
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
