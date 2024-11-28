<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RestaurantSeeder extends Seeder
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
            'user_id' => 1,
        ]);

        Restaurant::create([
            'name' => 'レストランＢ',
            'address' => '川の近く',
            'go' => false,
            'user_id' => 1,
        ]);

        Restaurant::create([
            'name' => 'レストランＣ',
            'address' => '学校の近く',
            'go' => true,
            'user_id' => 1,
        ]);
    }
}
