<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Product::create([
            'company_id' => 1,
            'product_name' => 'コーラ',
            'price' => 160,
            'stock' => 50,
            'comment' => '定番の炭酸飲料です。',
        ]);

        Product::create([
            'company_id' => 1,
            'product_name' => 'ジョージアコーヒー',
            'price' => 130,
            'stock' => 30,
            'comment' => 'ほっと一息つきたいときに。',
        ]);

        Product::create([
            'company_id' => 2,
            'product_name' => '伊右衛門',
            'price' => 150,
            'stock' => 40,
            'comment' => '香り高い緑茶です。',
        ]);

        Product::create([
            'company_id' => 3,
            'product_name' => '三ツ矢サイダー',
            'price' => 140,
            'stock' => 25,
            'comment' => 'すっきり爽快なサイダー。',
        ]);
    }
}