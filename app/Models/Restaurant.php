<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory;

    //一括代入を可能とする
    protected $fillable = [
        'name',
        'address',
        'go',
        'user_id',
    ];

    // ここに$castsを記載します
    protected $casts = [
        'go' => 'boolean', // 'go'カラムをboolean型として扱う
    ];

    /**
     * ユーザーとのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }
}
