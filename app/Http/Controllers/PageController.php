<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\ProductDiscount;
use App\Models\ProductVariant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'products' => ProductVariant::with('product')->get()
        ]);
    }

    public function detailProduct($id)
    {
        // dd(ProductVariant::with('product')->where('id', $id)->first());
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::with(['CartDetail.product.discounts', 'CartDetail.variant'])
            ->where('user_id', Auth::user()->id)
            ->first();

        $grandTotal = 0;
        $userRole = Auth::user()->role;

        if ($cart) {
            foreach ($cart->CartDetail as $detail) {

                $discount = ProductDiscount::calculateDiscount($detail->product->id, $detail->variant->id, $detail->qty, $userRole);

                if ($discount > 0) {

                    $priceAfterDiscount = $detail->price * (1 - $discount);
                    $subtotalAfterDiscount = $detail->qty * $priceAfterDiscount;

                    $detail->discount = $discount * 100;
                    $detail->price_after_discount = $priceAfterDiscount;
                    $detail->subtotal_after_discount = $subtotalAfterDiscount;

                    $grandTotal += $subtotalAfterDiscount;
                } else {

                    $detail->discount = 0;
                    $detail->price_after_discount = $detail->price;
                    $detail->subtotal_after_discount = $detail->qty * $detail->price;
                    $grandTotal += $detail->subtotal_after_discount;
                    // i
                }
            }
        }

        return view('pages.cart', [
            'cart' => $cart,
            'details' => $cart->CartDetail ?? collect(),
            'grandTotal' => $grandTotal,
        ]);
    }

    public function removeFromCart($id)
    {
        $cartProduct = CartDetail::find($id);

        if ($cartProduct) {
            $cartProduct->delete();
            return redirect()->route('cart')->with('success', 'Item berhasil dihapus dari keranjang.');
        }
        return redirect()->route('cart')->with('error', 'Item tidak ditemukan.');
    }


    public function generatePDF()
    {
        $user = Auth::user();
        $userRole = $user->role;
        $grandTotal = 0;

        // Ambil data keranjang dengan relasi yang diperlukan
        $cart = Cart::with(['CartDetail.product.discounts', 'CartDetail.variant'])
        ->where('user_id', $user->id)
            ->first();

        if ($cart) {
            foreach ($cart->CartDetail as $detail) {
                // Hitung diskon menggunakan fungsi yang sama seperti di cart()
                $discount = ProductDiscount::calculateDiscount(
                    $detail->product->id,
                    $detail->variant->id,
                    $detail->qty,
                    $userRole
                );

                if ($discount > 0) {
                    $priceAfterDiscount = $detail->price * (1 - $discount);
                    $subtotalAfterDiscount = $detail->qty * $priceAfterDiscount;

                    $detail->discount = $discount * 100;
                    $detail->price_after_discount = $priceAfterDiscount;
                    $detail->subtotal_after_discount = $subtotalAfterDiscount;

                    $grandTotal += $subtotalAfterDiscount;
                } else {
                    $detail->discount = 0;
                    $detail->price_after_discount = $detail->price;
                    $detail->subtotal_after_discount = $detail->qty * $detail->price;
                    $grandTotal += $detail->subtotal_after_discount;
                }
            }
        }

        // Generate PDF
        $pdf = PDF::loadView('pdf.invoice', [
            'user' => $user,
            'cart' => $cart,
            'details' => $cart ? $cart->CartDetail : collect(),
            'grandTotal' => $grandTotal
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('invoice.pdf');
    }
}
