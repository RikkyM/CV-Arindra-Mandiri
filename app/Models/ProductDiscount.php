<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $table = 'product_discounts';
    protected $fillable = ['product_id', 'variant_id', 'min_qty', 'max_qty', 'persentase_diskon', 'user_role'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variants()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public static function calculateDiscount($productId, $variantId = null, $qty)
    {
        $query = self::where('product_id', $productId);

        // Jika variant_id disediakan, tambahkan ke query
        if (!is_null($variantId)) {
            $query->where('variant_id', $variantId);
        }

        // Ambil semua aturan diskon
        $discountRules = $query->orderBy('min_qty', 'asc')->get();

        $bestDiscount = 0;

        // Iterasi aturan diskon untuk menemukan yang cocok dengan qty
        foreach ($discountRules as $rule) {
            if ($qty >= $rule->min_qty && ($rule->max_qty === null || $qty <= $rule->max_qty)) {
                // Simpan diskon terbaik (yang memiliki min_qty terbesar yang cocok dengan qty)
                if ($rule->min_qty <= $qty) {
                    $bestDiscount = max($bestDiscount, $rule->persentase_diskon); // Pilih diskon tertinggi yang cocok
                }
            }
        }

        return $bestDiscount; // Kembalikan diskon terbaik yang ditemukan
    }

}
