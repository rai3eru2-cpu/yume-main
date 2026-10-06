<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // 💡 仕様書に沿った複数形のテーブル名を明記
    protected $table = 'companies';

    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name',
    ];

    /**
     * productsテーブルとの1対多のリレーション（紐付け）を定義
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }
}