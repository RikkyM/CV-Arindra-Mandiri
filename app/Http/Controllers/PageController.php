<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'products' => Product::all()
        ]);
    }

    public function detailProduct($id)
    {
        return view('pages.detail-product', [
            'product' => Product::where('id', $id)->first()
        ]);
    }

    public function cartProduct($id, Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        $product = Product::where('id', $id)->first();


        $detailCart = CartDetail::where('cart_id', $cart->id)
        ->where('product_id', $id)
        ->first();

        if ($detailCart) {
            $detailCart->qty += $request->qty;
            $detailCart->subtotal = $detailCart->price * $detailCart->qty;
            $detailCart->save();
        } else {
            $detailCart = new CartDetail();
            $detailCart->cart_id = $cart->id;
            $detailCart->product_id = $id;
            $detailCart->qty = $request->qty;
            $detailCart->price = $product->price;
            $detailCart->subtotal = $product->price * $request->qty;
            $detailCart->status = 'pending';
            $detailCart->save();
        }

        $total = CartDetail::where('cart_id', $cart->id)->sum('subtotal');
        $cart->total = $total;
        $cart->save();

        return redirect()->route('home');
    }

    public function cart()
    {
        $cart = Cart::with('CartDetail.product')->where('user_id', Auth::user()->id)->first();

        return view('pages.cart', [
            'cart' => $cart,
            'details' => $cart->CartDetail
        ]);
    }
}
