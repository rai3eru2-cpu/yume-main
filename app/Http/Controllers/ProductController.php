<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest; // 指摘3
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
        $companyModel = new Company();
        
        // 全DB操作をモデルメソッドへ移行（指摘4）
        $products = $productModel->getListWithSearch(
            $request->input('search'),
            $request->input('company_id')
        );

        $companies = $companyModel->getCompaniesAll();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品情報登録画面を表示する
     */
    public function create()
    {
        $companyModel = new Company();
        $companies = $companyModel->getCompaniesAll(); // 指指4

        return view('products.create', compact('companies'));
    }

    /**
     * 商品情報登録処理を実行する
     */
    public function store(ProductRequest $request) // 指摘3
    {
        $productData = $request->validated();

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('products', 'public');
            $productData['img_path'] = $path;
        }

        $productModel = new Product();
        $productModel->storeProduct($productData);

        return redirect()->route('products.create')->with('success', '商品を新しく登録しました！'); // 指摘1
    } 

    /**
     * 商品情報詳細画面を表示する
     */
    public function show($id)
    {
        $productModel = new Product();
        $product = $productModel->getProductWithCompanyById($id); // 指摘4

        return view('products.show', compact('product'));
    }

    /**
     * 商品情報編集画面を表示する
     */
    public function edit($id)
    {
        $productModel = new Product();
        $companyModel = new Company();

        $product = $productModel->getProductById($id); // 指摘4
        $companies = $companyModel->getCompaniesAll(); // 指摘4

        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報更新処理を実行する
     */
    public function update(ProductRequest $request, $id) // 指摘3
    {
        $productModel = new Product();
        $product = $productModel->getProductById($id); // 指摘4
        
        $productData = $request->validated();

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('products', 'public');
            $productData['img_path'] = $path;
        }

        $product->updateProduct($productData);

        return redirect()->route('products.edit', ['id' => $id])->with('success', '商品情報を更新しました！'); // 指摘2
    }

    /**
     * 商品情報削除処理を実行する
     */
    public function destroy($id)
    {
        $productModel = new Product();
        $product = $productModel->getProductById($id); // 指摘4
        
        $product->destroyProduct();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}