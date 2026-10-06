<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 💡 仕様書に沿った複数形のテーブル名を明記
    protected $table = 'products';

    // 🛡️ プログラム側から一括保存を許可するカラム一覧（ホワイトリスト）
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    /**
     * companiesテーブルとの多対1のリレーション（紐付け）を定義
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}