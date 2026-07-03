<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Services\CartService;
use App\Exceptions\InsufficientStockException;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return view('cart.index');
    }

    public function data()
    {
        return response()->json([
            'success' => true,
            'cart' => $this->cartService->getCart(),
            'cart_count' => $this->cartService->getCount(),
            'cart_total' => $this->cartService->getCart()['total'] ?? 0
        ]);
    }

    public function add(CartAddRequest $request)
    {
        try {
            $this->cartService->add(
                $request->validated('tipe'),
                $request->validated('id_ref'),
                $request->validated('qty')
            );

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang.',
                'cart_count' => $this->cartService->getCount(),
                'cart_total' => $this->cartService->getCart()['total'] ?? 0
            ]);
        } catch (InsufficientStockException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(CartUpdateRequest $request)
    {
        try {
            $this->cartService->update(
                $request->validated('key'),
                $request->validated('qty')
            );

            return response()->json([
                'success' => true,
                'message' => 'Kuantitas berhasil diubah.',
                'cart_count' => $this->cartService->getCount(),
                'cart_total' => $this->cartService->getCart()['total'] ?? 0
            ]);
        } catch (InsufficientStockException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string'
        ]);

        $this->cartService->remove($request->input('key'));

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang.',
            'cart_count' => $this->cartService->getCount(),
            'cart_total' => $this->cartService->getCart()['total'] ?? 0
        ]);
    }

    public function clear()
    {
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan.',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }
}
