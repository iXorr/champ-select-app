<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString() ?: 'new';
        $categorySlug = $request->string('category')->toString();

        $query = Product::with('category')
            ->available();

        if ($categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $sortMap = [
            'new' => ['products.created_at', 'desc'],
            'name' => ['products.name', 'asc'],
            'price' => ['products.price', 'asc'],
            'country' => ['products.supplier_country', 'asc'],
        ];

        $order = $sortMap[$sort] ?? $sortMap['new'];
        $query->orderBy($order[0], $order[1]);

        $products = $query->paginate(9)->withQueryString();
        $categories = Category::orderBy('display_order')->get();

        return view('pages.catalog', [
            'products' => $products,
            'categories' => $categories,
            'selectedSort' => $sort,
            'selectedCategory' => $categorySlug,
        ]);
    }
}
