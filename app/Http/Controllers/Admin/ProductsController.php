<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pages.admin.products.index', [
            'products' => ProductVariant::with('product')->get(),
        ]);
    }

    public function create()
    {
        $productName = Product::whereHas('variant', function ($query) {
            $query->whereNotNull('variant');
        })->get();
        return view('pages.admin.products.add-product', [
            'products' => $productName
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $existingProduct = Product::where('nama_product', strtolower($value))->exists();
                        if ($existingProduct) {
                            $fail('Product name already exists.');
                        }
                    }
                }
            ],
            'product_name' => 'nullable',
            'variant' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $productName = strtolower(request('product_name') ?? request('nama_produk'));
                    $product = Product::where('nama_product', $productName)->first();

                    if ($product) {
                        $existingVariant = ProductVariant::where('product_id', $product->id)
                            ->where('variant', strtolower($value))
                            ->exists();

                        if ($existingVariant) {
                            $fail('Variant already exists for this product.');
                        }
                    }
                }
            ],
            'stock' => 'required|integer',
            'weight' => 'required|integer',
            'weight_unit' => 'required',
            'exc_ppn' => 'required|integer',
            'inc_ppn' => 'required|integer'
        ], [
            'nama_produk.unique' => 'Product name already exists.',
            'product_name.required_without' => 'Either select an existing product or create a new one.'
        ]);

        if (!empty($validatedData['product_name'])) {
            $productName = strtolower($validatedData['product_name']);
            $product = Product::where('nama_product', $productName)->first();
        } else {
            $productName = strtolower($validatedData['nama_produk']);
            $product = Product::where('nama_product', $productName)->first();

            if (!$product) {
                $product = Product::create([
                    'nama_product' => $productName
                ]);
            }
        }

        ProductVariant::create([
            'product_id' => $product->id,
            'variant' => $validatedData['variant'],
            'stock' => $validatedData['stock'],
            'weight' => $validatedData['weight'] . " " . $validatedData['weight_unit'],
            'exc_ppn' => $validatedData['exc_ppn'],
            'inc_ppn' => $validatedData['inc_ppn']
        ]);

        return redirect()->route('products');
    }

    public function EditKriteria($id)
    {
        $product = ProductVariant::with('product')->findOrFail($id);
        $discounts = ProductDiscount::where('variant_id', $id)->get();

        return view('pages.admin.products.update-kriteria', compact('product', 'discounts'));
    }

    public function UpdateKriteria($id, Request $request)
    {
        // dd($request->all

        $request->validate([
            'discounts.*.min_qty' => 'nullable|integer|required_with:discounts.*.percent_discount',
            'discounts.*.max_qty' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1]; // Ambil indeks dari atribut (e.g., discounts.{index}.max_qty)
                    $minQty = $request->input("discounts.$index.min_qty");

                    if ($value !== null && $minQty !== null && $value <= $minQty) {
                        $fail("Max quantity pada baris $index harus lebih besar dari Min quantity.");
                    }
                }
            ],
            'discounts.*.percent_discount' => 'nullable|integer|required_with:discounts.*.min_qty',
            'discounts.*.user_role' => 'nullable|string|in:toko,konsumen'
        ]);

        $product = ProductVariant::with('product')->findOrFail($id);

        // Clear existing discounts hanya untuk `variant_id` dan `user_role` yang sama
        ProductDiscount::where('variant_id', $id)->delete();

        foreach ($request->discounts as $discount) {
            if (!empty($discount['min_qty']) && !empty($discount['percent_discount'])) {
                // Simpan setiap diskon dengan mempertimbangkan user_role
                ProductDiscount::create([
                    'product_id' => $product->product->id,
                    'variant_id' => $id,
                    'min_qty' => $discount['min_qty'],
                    'max_qty' => $discount['max_qty'],
                    'persentase_diskon' => $discount['percent_discount'] / 100,
                    'user_role' => $discount['user_role']
                ]);
            }
        }

        return redirect()->back()->with('success', 'Kriteria discount berhasil diperbarui');
    }

}
