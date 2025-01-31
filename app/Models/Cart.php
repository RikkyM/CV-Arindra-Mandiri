<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = ['user_id', 'status', 'total'];

    public function CartDetail()
    {
        return $this->hasMany(CartDetail::class, 'cart_id');
    }
}
