<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('features')
            ->withCount('orderItems')
            ->orderBy('title')
            ->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function show(Product $product)
    {
        $product->load('features');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('features');

        return view('products.edit', compact('product'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['image_path'] = $this->storeImage($request);

        $product = Product::create($data);

        if ($request->filled('roast_level') || $request->filled('country')) {
            $product->features()->create([
                'roast_level' => $request->roast_level,
                'country' => $request->country,
            ]);
        }

        return redirect()
            ->route('products.show', $product)
            ->with('status', 'Товар добавлен');
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Название и единицу менять нельзя
        $data['title'] = $product->title;
        $data['unit'] = $product->unit;

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $data['image_path'] = $this->storeImage($request);
        } else {
            unset($data['image']);
        }

        $product->update($data);

        if ($request->hasAny(['roast_level', 'country'])) {
            $product->features()->delete();

            if ($request->filled('roast_level') || $request->filled('country')) {
                $product->features()->create([
                    'roast_level' => $request->roast_level,
                    'country' => $request->country,
                ]);
            }
        }

        return redirect()
            ->route('products.show', $product)
            ->with('status', 'Товар обновлен');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return back()->withErrors([
                'general' => 'Нельзя удалить товар, который уже использовался в заказах',
            ]);
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'Товар удален');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return back()->withErrors(['file' => 'Файл не передан']);
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = $this->convertRow(fgetcsv($handle, 0, ';'));

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $row = $this->convertRow($row);
            $data = $header ? array_combine($header, $row) : $row;

            Product::create([
                'title' => $data['title'] ?? $row[0],
                'manufacturer' => $data['manufacturer'] ?? $row[1] ?? '',
                'price' => (int)($data['price'] ?? $row[2] ?? 0),
                'unit' => $data['unit'] ?? $row[3] ?? 'шт',
                'short_description' => $data['short_description'] ?? $row[4] ?? '',
                'description' => $data['description'] ?? $row[5] ?? '',
                'image_path' => null,
            ]);
        }

        fclose($handle);

        return redirect()
            ->route('products.index')
            ->with('status', 'Импорт завершен');
    }

    private function storeImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        return $request->file('image')
            ->store('products', 'public');
    }

    private function convertRow(array $row): array
    {
        return array_map(function ($value) {
            $value = (string)$value;

            return mb_detect_encoding($value, 'UTF-8', true)
                ? $value
                : iconv('Windows-1251', 'UTF-8//IGNORE', $value);
        }, $row);
    }
}
