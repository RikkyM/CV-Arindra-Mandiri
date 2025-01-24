<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'products' => ProductVariant::all()
        ]);
    }

    public function detailProduct($id)
    {
        return view('pages.detail-product', [
            'product' => ProductVariant::with('product')->where('id', $id)->first()
        ]);
    }

    public function cartProduct($id, Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        $product = ProductVariant::with('product')->where('id', $id)->first();

        $detailCart = CartDetail::where('cart_id', $cart->id)
            ->where('product_id', $product->product->id)
            ->where('variant_id', $id)
            ->first();

        if ($detailCart) {
            if (!$detailCart->price) {
                $detailCart->price = $product->inc_ppn;
            }

            $detailCart->qty += $request->qty;
            $detailCart->subtotal = $detailCart->price * $detailCart->qty;
            $detailCart->save();
        } else {
            $detailCart = new CartDetail();
            $detailCart->cart_id = $cart->id;
            $detailCart->product_id = $product->product->id;
            $detailCart->variant_id = $id;
            $detailCart->qty = $request->qty;
            $detailCart->price = $product->inc_ppn;
            $detailCart->subtotal = $product->inc_ppn * $request->qty;
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
        $cart = Cart::with(['CartDetail.product.discounts', 'CartDetail.variant'])
            ->where('user_id', Auth::user()->id)
            ->first();

        $grandTotal = 0;
        $userRole = Auth::user()->role;  // Mengambil role dari akun yang login

        if ($cart) {
            foreach ($cart->CartDetail as $detail) {
                // Hitung diskon untuk produk berdasarkan user role
                $discount = ProductDiscount::calculateDiscount($detail->product->id, $detail->variant->id, $detail->qty, $userRole);

                if ($discount > 0) {
                    // Harga setelah diskon: karena diskon sudah dalam bentuk desimal, tidak perlu dibagi 100 lagi
                    $priceAfterDiscount = $detail->price * (1 - $discount); // diskon langsung dalam desimal
                    $subtotalAfterDiscount = $detail->qty * $priceAfterDiscount;

                    // Update detail produk
                    $detail->discount = $discount * 100; // Konversi ke persentase untuk ditampilkan
                    $detail->price_after_discount = $priceAfterDiscount;
                    $detail->subtotal_after_discount = $subtotalAfterDiscount;

                    // Tambahkan ke grand total
                    $grandTotal += $subtotalAfterDiscount;
                } else {
                    // Jika tidak ada diskon, gunakan harga normal
                    $detail->discount = 0;
                    $detail->price_after_discount = $detail->price;
                    $detail->subtotal_after_discount = $detail->qty * $detail->price;

                    // Tambahkan ke grand total tanpa diskon
                    $grandTotal += $detail->subtotal_after_discount;
                }
            }
        }

        return view('pages.cart', [
            'cart' => $cart,
            'details' => $cart->CartDetail ?? collect(),
            'grandTotal' => $grandTotal,  // Pass grand total to view
        ]);
    }



}
