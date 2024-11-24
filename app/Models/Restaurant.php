<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory;

    //一括代入を可能とする
    protected $fillable = [
        'name',
        'address',
        'go',
    ];

    // ここに$castsを記載します
    protected $casts = [
        'go' => 'boolean', // 'go'カラムをboolean型として扱う
    ];
}
