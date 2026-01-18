<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'manufacturer',
        'image_path',
        'price',
        'unit',
        'short_description',
        'description',
    ];
}
