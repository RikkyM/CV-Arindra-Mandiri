<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Invoice;
use App\Models\ProductDiscount;
use App\Models\ProductVariant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
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


    public function generatePDF(Request $request)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $grandTotal = 0;

        $cart = Cart::with(['CartDetail.product.discounts', 'CartDetail.variant'])
        ->where('user_id', $user->id)
            ->first();

        if ($cart) {
            $filteredDetails = collect();

            foreach ($cart->CartDetail as $detail) {
                $qty = $request->input('qty.' . $detail->id, $detail->qty);

                if ($qty <= 0) {
                    continue;
                }

                $discount = ProductDiscount::calculateDiscount(
                    $detail->product->id,
                    $detail->variant->id,
                    $qty,
                    $userRole
                );

                if ($discount > 0) {
                    $priceAfterDiscount = $detail->price * (1 - $discount);
                    $subtotalAfterDiscount = $qty * $priceAfterDiscount;

                    $detail->discount = $discount * 100;
                    $detail->price_after_discount = $priceAfterDiscount;
                    $detail->subtotal_after_discount = $subtotalAfterDiscount;

                    $grandTotal += $subtotalAfterDiscount;
                } else {
                    $detail->discount = 0;
                    $detail->price_after_discount = $detail->price;
                    $detail->subtotal_after_discount = $qty * $detail->price;
                    $grandTotal += $detail->subtotal_after_discount;
                }

                $detail->qty = $qty;
                $filteredDetails->push($detail);
            }

            // **Generate Nomor Faktur dan Order Number**
            $year = now()->format('y'); // Ambil dua digit tahun (misal 25 untuk 2025)
            $lastInvoice = Invoice::where('invoice_number', 'LIKE', "AM/$year/%")
            ->orderBy('id', 'desc')
                ->first();

            $nextNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -5)) + 1 : 1;

            // **Format nomor faktur & order number**
            $invoiceNumber = sprintf('AM/%s/%05d', $year, $nextNumber);
            $orderNumber = sprintf('%s/%05d', $year, $nextNumber); // Tanpa "AM/"

            // **Generate PDF**
            $pdf = PDF::loadView('pdf.invoice', [
                'user' => $user,
                'cart' => $cart,
                'details' => $filteredDetails,
                'grandTotal' => $grandTotal,
                'invoiceNumber' => $invoiceNumber,
                'orderNumber' => $orderNumber
            ]);

            $pdf->setPaper('A4', 'landscape');

            // **Simpan PDF dalam Folder `invoice/`**
            $fileName = 'invoice_' . sprintf('%05d', $nextNumber) . '.pdf';
            $filePath = 'invoice/' . $fileName; // Folder invoice/
            Storage::put($filePath, $pdf->output());

            // **Simpan Faktur ke Database**
            Invoice::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'order_number' => $orderNumber,
                'file_path' => $filePath
            ]);

            return $pdf->stream($fileName);
        }

        return back()->with('error', 'Cart is empty');
    }


    public function sendPDF(Request $request)
    {
        $filePath = $this->generatePDF($request);

        $fileUrl = route('storage.pdf', ['filename' => basename($filePath)]);

        $message = "Berikut adalah link untuk mengunduh invoice Anda:\n" . $fileUrl;

        $phoneNumber = "6289690795500";
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }

    public function getPDF($filename)
    {
        $filePath = 'invoice/' . $filename;

        if (!Storage::exists($filePath)) {
            abort(404, 'File not found.');
        }

        $fileContent = Storage::get($filePath);

        $mimeType = Storage::mimeType($filePath);

        return new Response(
            $fileContent,
            200,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }
}
