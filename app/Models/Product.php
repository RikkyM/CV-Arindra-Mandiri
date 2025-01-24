<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ['nama_product', 'slug', 'stock', 'price'];

    public function variant()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function varian()
    {
        return $this->hasOne(ProductVariant::class);
    }
}
