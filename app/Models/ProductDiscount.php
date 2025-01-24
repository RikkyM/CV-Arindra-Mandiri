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

    public static function calculateDiscount($productId, $variantId, $qty)
    {
        $discountRules = self::where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->orderBy('min_qty', 'asc')
            ->get();

        foreach ($discountRules as $rule) {
            if ($qty >= $rule->min_qty && ($rule->max_qty === null || $qty <= $rule->max_qty)) {
                return $rule->persentase_diskon;
            }
        }

        return 0;
    }
}
