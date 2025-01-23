<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pages.admin.products', [
            'products' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'stok' => 'required',
            'harga' => 'required'
        ]);

        Product::create([
            'nama_product' => $request->nama_produk,
            'stock' => $request->stok,
            'price' => $request->harga
        ]);

        return redirect()->back();
    }
}
