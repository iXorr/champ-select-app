<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(CartItemRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $product = Product::available()->findOrFail($data['product_id']);
        $quantity = (int) ($data['quantity'] ?? 1);

        $cartItem = CartItem::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $newQuantity = $cartItem->exists ? $cartItem->quantity + $quantity : $quantity;

        if ($newQuantity > $product->stock) {
            return response()->json([
                'message' => 'Нельзя добавить больше, чем есть в наличии.',
                'cart' => $this->summary($user),
            ], 422);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return response()->json([
            'message' => 'Товар добавлен в корзину.',
            'item' => $cartItem->load('product'),
            'cart' => $this->summary($user),
        ]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $this->authorizeCartItem($request, $cartItem);

        $quantity = (int) $request->input('quantity');
        $product = $cartItem->product;

        if ($quantity < 1) {
            $cartItem->delete();

            return response()->json([
                'message' => 'Товар удален из корзины.',
                'cart' => $this->summary($request->user()),
            ]);
        }

        if ($quantity > $product->stock) {
            return response()->json([
                'message' => 'Запрошенное количество превышает остаток.',
                'cart' => $this->summary($request->user()),
            ], 422);
        }

        $cartItem->update(['quantity' => $quantity]);

        return response()->json([
            'message' => 'Количество обновлено.',
            'cart' => $this->summary($request->user()),
        ]);
    }

    public function destroy(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->authorizeCartItem($request, $cartItem);

        $cartItem->delete();

        return response()->json([
            'message' => 'Товар удален из корзины.',
            'cart' => $this->summary($request->user()),
        ]);
    }

    protected function authorizeCartItem(Request $request, CartItem $cartItem): void
    {
        abort_if($cartItem->user_id !== $request->user()->id, 403);
    }

    protected function summary($user): array
    {
        $items = $user->cartItems()->with('product')->get();

        return [
            'count' => $items->sum('quantity'),
            'total' => $items->sum(fn ($item) => $item->quantity * $item->product->price),
            'items' => $items->map(fn ($item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'stock' => $item->product->stock,
                'name' => $item->product->name,
                'price' => $item->product->price,
            ])->values(),
        ];
    }
}
