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
        $query = self::where('product_id', $productId);

        if (!is_null($variantId)) {
            $query->where('variant_id', $variantId);
        }

        $query->where('user_role', $userRole);

        $discountRules = $query->orderByDesc('min_qty')->get();

        $bestDiscount = 0;

        foreach ($discountRules as $rule) {

            if ($qty >= $rule->min_qty && ($rule->max_qty === null || $qty <= $rule->max_qty)) {

                $bestDiscount = max($bestDiscount, $rule->persentase_diskon);
            }
        }

        return $bestDiscount;
    }
}
