<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest; // 新しいリクエストクラスをインポート（指摘3）
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * 商品情報一覧画面を表示する（検索機能付き）
     */
    public function index(Request $request)
    {
        $productModel = new Product();
        
        // モデルのメソッドを呼び出して絞り込み結果を取得（指摘4）
        $products = $productModel->getListWithSearch(
            $request->input('search'),
            $request->input('company_id')
        );

        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品情報登録画面を表示する
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品情報登録処理を実行する
     */
    public function store(ProductRequest $request) // フォームリクエストを指定（指摘3）
    {
        // バリデーション済みの安全なデータを取得
        $productData = $request->validated();

        // 画像ファイルがアップロードされている場合の処理
        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('products', 'public');
            $productData['img_path'] = $path;
        }

        // モデルのメソッドを呼び出してデータベースへ登録実行（指摘4）
        $productModel = new Product();
        $productModel->storeProduct($productData);

        // 仕様書ルール：登録完了後は「自画面（登録画面）」へリダイレクト（指摘1）
        return redirect()->route('products.create')->with('success', '商品を新しく登録しました！');
    } 

    /**
     * 商品情報詳細画面を表示する
     */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 商品情報編集画面を表示する
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報更新処理を実行する
     */
    public function update(ProductRequest $request, $id) // フォームリクエストを指定（指摘3）
    {
        $product = Product::findOrFail($id);
        
        // バリデーション済みの安全なデータを取得
        $productData = $request->validated();

        // 新しい画像ファイルがアップロードされた場合の処理
        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('products', 'public');
            $productData['img_path'] = $path;
        }

        // モデルのメソッドを呼び出してデータベースの情報を更新（指摘4）
        $product->updateProduct($productData);

        // 仕様書ルール：編集完了後は「自画面（編集画面）」へリダイレクト（指摘2）
        return redirect()->route('products.edit', ['id' => $id])->with('success', '商品情報を更新しました！');
    }

    /**
     * 商品情報削除処理を実行する
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // モデルのメソッドを呼び出してデータベースから削除（指摘4）
        $product->destroyProduct();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}