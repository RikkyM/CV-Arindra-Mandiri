<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pages.admin.products.index', [
            'products' => ProductVariant::with('product')->get(),
        ]);
    }

    public function show($path)
    {
        if (!Storage::exists($path)) {
            abort(404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file)
            ->header('Content-Type', $type)
            ->header('Cache-Control', 'public, max-age=86400');
    }

    public function showImage($id)
    {
        $productVariant = ProductVariant::findOrFail($id);

        if (!$productVariant->image || !Storage::exists($productVariant->image)) {
            abort(404);
        }

        return response()->file(Storage::path($productVariant->image));
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
            'inc_ppn' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg'
        ], [
            'nama_produk.unique' => 'Product name already exists.',
            'product_name.required_without' => 'Either select an existing product or create a new one.'
        ]);

        $file = $request->file('image');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $imagePath = $file->storeAs('products', $fileName);

        if (!empty($validatedData['product_name'])) {
            $productName = strtolower($validatedData['product_name']);
            $product = Product::where('nama_product', $productName)->first();
        } else {
            $productName = strtolower($validatedData['nama_produk']);
            $product = Product::where('nama_product', $productName)->first();

            if (!$product) {
                $product = Product::create([
                    'nama_product' => $productName,
                    'gambar_product' => $imagePath
                ]);
            }
        }

        ProductVariant::create([
            'product_id' => $product->id,
            'variant' => $validatedData['variant'],
            'stock' => $validatedData['stock'],
            'weight' => $validatedData['weight'] . " " . $validatedData['weight_unit'],
            'exc_ppn' => $validatedData['exc_ppn'],
            'inc_ppn' => $validatedData['inc_ppn'],
        ]);

        return redirect()->route('products');
    }

    public function edit($id)
    {
        $productVariant = ProductVariant::with('product')->findOrFail($id);
        return view('pages.admin.products.edit-product', [
            'productVariant' => $productVariant
        ]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => [
                'required',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $productVariant = ProductVariant::findOrFail($id);
                        $existingProduct = Product::where('nama_product', strtolower($value))
                            ->where('id', '!=', $productVariant->product_id)
                            ->exists();

                        if ($existingProduct) {
                            $fail('Product name already exists.');
                        }
                    }
                }
            ],
            'variant' => [
                'required',
                function ($attribute, $value, $fail) use ($id) {
                    $productVariant = ProductVariant::findOrFail($id);
                    $existingVariant = ProductVariant::where('product_id', $productVariant->product_id)
                        ->where('variant', strtolower($value))
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($existingVariant) {
                        $fail('Variant already exists for this product.');
                    }
                }
            ],
            'stock' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'weight_unit' => 'required|in:GR,KG,JAR,PAIL',
            'exc_ppn' => 'required|integer|min:0',
            'inc_ppn' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        try {
            $productVariant = ProductVariant::findOrFail($id);
            $product = $productVariant->product;

            if ($request->hasFile('image')) {
                if ($product->gambar_product) {
                    Storage::delete($product->gambar_product);
                }

                $file = $request->file('image');
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('products', $fileName);

                $product->gambar_product = $imagePath;
            }

            $product->nama_product = strtolower($validatedData['nama_produk']);
            $product->save();

            $productVariant->update([
                'variant' => strtolower($validatedData['variant']),
                'stock' => $validatedData['stock'],
                'weight' => $validatedData['weight'] . " " . $validatedData['weight_unit'],
                'exc_ppn' => $validatedData['exc_ppn'],
                'inc_ppn' => $validatedData['inc_ppn']
            ]);

            return redirect()->route('products')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update product. Please try again.']);
        }
    }

    public function EditKriteria($id)
    {
        $product = ProductVariant::with('product')->findOrFail($id);
        $discounts = ProductDiscount::where('variant_id', $id)->get();

        return view('pages.admin.products.update-kriteria', compact('product', 'discounts'));
    }

    public function UpdateKriteria($id, Request $request)
    {
        $request->validate([
            'discounts.*.min_qty' => 'nullable|integer|required_with:discounts.*.percent_discount',
            'discounts.*.max_qty' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
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

        ProductDiscount::where('variant_id', $id)->delete();

        foreach ($request->discounts as $discount) {
            if (!empty($discount['min_qty']) && !empty($discount['percent_discount'])) {
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

    public function detailProduct($id)
    {
        $product = Product::with(['varian', 'discounts'])->find($id);
        return view('pages.admin.products.detail-product', [
            'product' => $product,
            'kriteria' => $product->discounts
        ]);
    }
}
