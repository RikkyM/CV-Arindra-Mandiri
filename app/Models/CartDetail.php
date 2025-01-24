<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_details';
    protected $fillable = ['cart_id', 'product_id', 'variant_id', 'qty', 'price', 'subtotal'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
