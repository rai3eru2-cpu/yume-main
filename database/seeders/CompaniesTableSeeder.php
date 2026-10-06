<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'company_name' => 'コカ・コーラ',
                'street_address' => '東京都渋谷区',
                'representative_name' => '山田太郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'サントリー',
                'street_address' => '大阪府大阪市',
                'representative_name' => '鈴木次郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'キリン',
                'street_address' => '東京都中野区',
                'representative_name' => '佐藤三郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}