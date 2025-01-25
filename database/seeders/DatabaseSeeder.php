<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // k

        $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'status_akun' => 'active'
            ],
            [
                'name' => 'rikky mahendra',
                'username' => 'rikky32',
                'password' => Hash::make('123123'),
                'role' => 'konsumen',
                'status_akun' => 'inactive'
            ]
        ];

        $products = [
            [
                'nama_product' => 'dunia compound dark'
            ],
            [
                'nama_product' => 'dunia super compount / prima'
            ],
        ];

        $variants = [
            [
                'product_id' => 1,
                'variant' => 'ekonomi',
                'stock' => 20,
                'weight' => '1 KG',
                'exc_ppn' => 361000,
                'inc_ppn' => 400710
            ],
            [
                'product_id' => 1,
                'variant' => 'decor',
                'stock' => 42,
                'weight' => '250 GR',
                'exc_ppn' => 266000,
                'inc_ppn' => 295260
            ],
            [
                'product_id' => 2,
                'variant' => null,
                'stock' => 13,
                'weight' => '250 GR',
                'exc_ppn' => 308000,
                'inc_ppn' => 341880
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        foreach ($products as $product) {
            Product::create($product);
        }

        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }

        Cart::create([
            'user_id' => 2,
            'total' => 0
        ]);
    }
}
