<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //データベースを操作するから追加
use Carbon\Carbon; //日付を便利に扱いたいから追加
use App\Models\Restaurant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レストランデータを流し込む
        Restaurant::create([
            'name' => 'レストランＡ',
            'address' => '駅の近く',
            'go' => true,
        ]);

        Restaurant::create([
            'name' => 'レストランＢ',
            'address' => '川の近く',
            'go' => false,
        ]);

        Restaurant::create([
            'name' => 'レストランＣ',
            'address' => '学校の近く',
            'go' => true,
        ]);

        Restaurant::create([
            'name' => 'レストランＤ',
            'address' => '空港の近く',
            'go' => false,
        ]);
    }
}
