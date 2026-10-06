<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * 商品情報一覧画面を表示する（検索機能付き）
     */
    public function index(Request $request)
    {
        // 1. 検索の土台となるクエリを作成（メーカー情報も同時に取得）
        $query = Product::with('company');

        // 2. 商品名（キーワード）が入力されている場合、部分一致で絞り込み
        if ($request->filled('search')) {
            $query->where('product_name', 'LIKE', '%' . $request->input('search') . '%');
        }

        // 3. メーカーがセレクトボックスで選択されている場合、完全一致で絞り込み
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        // 4. 絞り込んだ結果の商品データをデータベースから取得
        $products = $query->get();

        // セレクトボックスの選択肢用に、すべてのメーカーデータを取得
        $companies = Company::all();

        // 画面（view）を開く際に、結果の $products と $companies を一緒に渡す
        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品情報登録画面を表示する
     */
    public function create()
    {
        // セレクトボックス用にメーカーの一覧を取得
        $companies = Company::all();

        return view('products.create', compact('companies'));
    }

    /**
     * 商品情報登録処理を実行する
     */
    public function store(Request $request)
    {
        // 1. 入力値のバリデーションチェック（仕様書の必須項目「*」に準拠）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MBまでの画像
        ]);

        // コーディング規約：変数名はローワーキャメル
        $productData = $request->all();

        // 2. 画像ファイルがアップロードされている場合の処理
        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            // storage/app/public/products フォルダに一意の名前で保存
            $path = $image->store('products', 'public');
            // データベースに保存するパスをセット
            $productData['img_path'] = $path;
        }

        // 3. データベースへの登録実行
        Product::create($productData);

        // 4. 登録完了後は商品情報一覧画面へリダイレクト
        return redirect()->route('products.index');
    } 

    /**
     * 商品情報詳細画面を表示する
     */
    public function show($id)
    {
        // データベースから指定されたIDの商品データを1件取得（メーカー情報付き）
        $product = Product::with('company')->findOrFail($id);

        // 画面（show.blade.php）を開く際に、取得した商品データを渡す
        return view('products.show', compact('product'));
    }

    /**
     * 商品情報編集画面を表示する
     */
    public function edit($id)
    {
        // 編集対象の商品データを1件取得
        $product = Product::findOrFail($id);
        // メーカー選択用の一覧を取得
        $companies = Company::all();

        // 画面（edit.blade.php）にデータを渡して開く
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報更新処理を実行する
     */
    public function update(Request $request, $id)
    {
        // 1. 入力値のバリデーションチェック（登録時と同じ仕様）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $productData = $request->all();

        // 2. 新しい画像ファイルがアップロードされた場合の処理
        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('products', 'public');
            $productData['img_path'] = $path;
        }

        // 3. データベースの情報を更新
        $product->update($productData);

        // 4. 仕様書ルール：編集完了後は「詳細画面（show）」へリダイレクト
        return redirect()->route('products.show', ['id' => $id]);
    }

    /**
     * 商品情報削除処理を実行する
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // データベースから削除
        $product->delete();

        // 仕様書ルール：削除後は「一覧画面」へリダイレクト
        return redirect()->route('products.index');
    }
}
