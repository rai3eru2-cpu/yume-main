<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

// トップページにアクセスしたらログイン画面、または商品一覧にリダイレクト
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Laravel UIが自動生成した認証関連のルーティング（ログイン・新規登録など）
Auth::routes();

// 💡 ログイン認証（auth）が必須な画面のグループ
Route::group(['middleware' => 'auth'], function () {
    
    // 商品情報一覧画面
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    // 商品情報登録画面（フォーム表示）
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    
    // 商品情報登録処理（DB保存）
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    
    // 商品情報詳細画面
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    
    // 商品情報編集画面（フォーム表示）
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    
    // 商品情報更新処理（DB保存）
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    
    // 商品情報削除処理
    Route::post('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
});