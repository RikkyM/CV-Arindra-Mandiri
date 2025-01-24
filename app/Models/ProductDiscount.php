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

    public static function calculateDiscount($productId, $variantId = null, $qty, $userRole)
    {
        // Query untuk mencari diskon berdasarkan product_id, variant_id, dan user_role
        $query = self::where('product_id', $productId);

        // Jika variant_id disediakan, tambahkan ke query
        if (!is_null($variantId)) {
            $query->where('variant_id', $variantId);
        }

        // Menyaring berdasarkan role pengguna
        $query->where('user_role', $userRole);

        // Ambil aturan diskon yang relevan
        $discountRules = $query->orderByDesc('min_qty')->get(); // Urutkan berdasarkan min_qty terbesar

        $bestDiscount = 0; // Default tidak ada diskon

        // Iterasi aturan diskon untuk menemukan yang paling cocok dan terbaik
        foreach ($discountRules as $rule) {
            // Periksa apakah qty memenuhi syarat untuk diskon ini
            if ($qty >= $rule->min_qty && ($rule->max_qty === null || $qty <= $rule->max_qty)) {
                // Pilih diskon yang paling cocok
                $bestDiscount = max($bestDiscount, $rule->persentase_diskon);
            }
        }

        return $bestDiscount; // Mengembalikan diskon terbaik yang ditemukan
    }


}
