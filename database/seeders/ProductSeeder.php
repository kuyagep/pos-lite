<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Americano',
                'category' => 'Coffee',
                'price' => 80.00,
                'stock' => 50,
                'low_stock_alert' => 5,
                'qr_code' => 'americano-001',
            ],
            [
                'name' => 'Cappuccino',
                'category' => 'Coffee',
                'price' => 100.00,
                'stock' => 40,
                'low_stock_alert' => 5,
                'qr_code' => 'cappuccino-001',
            ],
            [
                'name' => 'Latte',
                'category' => 'Coffee',
                'price' => 95.00,
                'stock' => 30,
                'low_stock_alert' => 5,
                'qr_code' => 'latte-001',
            ],
            [
                'name' => 'Espresso',
                'category' => 'Coffee',
                'price' => 70.00,
                'stock' => 60,
                'low_stock_alert' => 5,
                'qr_code' => 'espresso-001',
            ],
            [
                'name' => 'Iced Coffee',
                'category' => 'Cold Drinks',
                'price' => 85.00,
                'stock' => 25,
                'low_stock_alert' => 5,
                'qr_code' => 'icedcoffee-001',
            ],
            [
                'name' => 'Blueberry Muffin',
                'category' => 'Pastry',
                'price' => 60.00,
                'stock' => 20,
                'low_stock_alert' => 3,
                'qr_code' => 'muffin-blueberry-001',
            ],
            [
                'name' => 'Cheesecake Slice',
                'category' => 'Dessert',
                'price' => 120.00,
                'stock' => 15,
                'low_stock_alert' => 2,
                'qr_code' => 'cheesecake-001',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
