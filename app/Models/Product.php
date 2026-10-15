<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 一括画面登録を許可する項目を設定
    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    /**
     * メーカーテーブルとのリレーション定義
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 商品情報一覧の検索・取得処理（指摘4）
     */
    public function getListWithSearch($search, $companyId)
    {
        $query = self::with('company');

        if (!empty($search)) {
            $query->where('product_name', 'LIKE', '%' . $search . '%');
        }

        if (!empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        return $query->get();
    }

    /**
     * 新規商品登録処理（指摘4）
     */
    public function storeProduct(array $data)
    {
        return self::create($data);
    }

    /**
     * 商品更新処理（指摘4）
     */
    public function updateProduct(array $data)
    {
        return $this->update($data);
    }

    /**
     * 商品削除処理（指摘4）
     */
    public function destroyProduct()
    {
        return $this->delete();
    }

    /**
     * 指定されたIDの商品データを1件取得する（指摘4）
     */
    public function getProductById($id)
    {
        return self::findOrFail($id);
    }

    /**
     * 指定されたIDの商品データをメーカー情報付きで1件取得する（指摘4）
     */
    public function getProductWithCompanyById($id)
    {
        return self::with('company')->findOrFail($id);
    }
}