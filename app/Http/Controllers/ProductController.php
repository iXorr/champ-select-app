<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ImportCsvRequest;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'products' => Product::all()
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    private function storeImage(Request $request, Product $product = null)
    {
        if ($request->hasFile('image'))
            return $request->file('image')->store('products', 'public');

        if ($product)
            return $product->image_path
                ? $product->image_path
                : null;

        return null;
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['image_path'] = $this->storeImage($request);

        $product = Product::create($data);
        
        return redirect()
            ->route('products.index')
            ->with('message', 'Товар создан');
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('message', 'Товар изменён');
    }

    public function destroy(Product $product)
    {
        // if ($product->orderItems->isNotEmpty()) {
        //     dd('not skipped');
        // }

        // dd('skipped');

        $product->delete();
        
        return redirect()
            ->route('products.index')
            ->with('message', 'Товар удалён');
    }

    public function import(ImportCsvRequest $request)
    {
        $data = $request->validated();

        $handle = fopen($data['file']->getRealPath(), 'r');
        $header = fgetcsv($handle, 0, ';');

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (!mb_check_encoding($row, 'UTF-8'))
                $row = mb_convert_encoding($row, 'UTF-8', 'Windows-1251');

            Product::create(array_combine($header, $row));
        }
        
        return redirect()
            ->route('products.index')
            ->with('message', 'Импорт завершён');
    }
}
