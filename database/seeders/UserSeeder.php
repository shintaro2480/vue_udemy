<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ID=1番のユーザーを作成
        User::updateOrCreate(
            ['id' => 1], // 同じIDが存在する場合は更新
            [
                'name' => '竹本晋太郎',
                'email' => 'createlab@hotmail.co.jp',
                'password' => Hash::make('muse2222'),
            ]
        );
    }
}
