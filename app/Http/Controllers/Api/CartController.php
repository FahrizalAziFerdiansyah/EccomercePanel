<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::with('product')->where('user_id', $request->id)->get();
        return response([
            'success' => true,
            'data' => $cart
        ], 201);
    }
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        if ($request->amount > $product->stock) {
            return response([
                'success'   => false,
                'errors' => "Stock not enough"
            ], 404);
        }
        $cart = Cart::with('product')->where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
        $data = [
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
        ];
        if ($cart) {
            if (($cart->amount + $request->amount) > $product->stock) {
                return response([
                    'success'   => false,
                    'errors' => "Stock not enough, you have " . $cart->amount . " in your cart"
                ], 404);
            } else {
                $data['amount'] = $data['amount'] + $cart->amount;
                $cart->update($data);
            }
        } else {
            $cart = Cart::create($data);
        }
        return response([
            'success' => true,
            'data' => $cart
        ], 201);
    }

    public function delete(Request $request)
    {
        $cart = Cart::with('product')->where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
        $cart->delete();
        return response([
            'success' => true,
            'data' => $cart
        ], 201);
    }
}
