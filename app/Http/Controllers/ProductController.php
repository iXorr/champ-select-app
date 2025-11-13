<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_if(! $product->is_active || $product->stock < 1, 404);

        $similar = Product::available()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('pages.product', [
            'product' => $product->load('category'),
            'similarProducts' => $similar,
        ]);
    }
}
