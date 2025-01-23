<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Product;
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

        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'status_akun' => 'active'
            ],
            [
                'name' => 'rikky mahendra',
                'email' => 'rikky.mahendra54@gmail.com',
                'password' => Hash::make('123123'),
                'role' => 'konsumen',
                'status_akun' => 'inactive'
            ]
        ];

        $products = [
            [
                'nama_product' => 'cream cheese',
                'stock' => '20',
                'price' => '1450000'
            ],
            [
                'nama_product' => 'keju edam',
                'stock' => '32',
                'price' => '2437750'
            ],
            [
                'nama_product' => 'tulip burgundy',
                'stock' => '34',
                'price' => '1678000'
            ],
            [
                'nama_product' => 'cocoa powder',
                'stock' => '10',
                'price' => '5000000'
            ],
            [
                'nama_product' => 'colatta chip',
                'stock' => '54',
                'price' => '325000'
            ],
            [
                'nama_product' => 'meses holland',
                'stock' => '28',
                'price' => '615000'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        foreach ($products as $product) {
            Product::create($product);
        }

        Cart::create([
            'user_id' => 2,
            'total' => 0
        ]);
    }
}
