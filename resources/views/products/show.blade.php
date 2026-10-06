@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">商品情報詳細画面</h2>

            <div class="card">
                <div class="card-body">
                    <!-- ID -->
                    <p><strong>ID:</strong> {{ $product->id }}</p>
                    
                    <!-- 商品画像 -->
                    <p><strong>商品画像:</strong><br>
                        @if($product->img_path)
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" style="width: 200px; height: auto;" class="mt-2">
                        @else
                            <span class="text-muted">画像なし</span>
                        @endif
                    </p>
                    
                    <!-- 商品名 -->
                    <p><strong>商品名:</strong> {{ $product->product_name }}</p>
                    
                    <!-- メーカー名 -->
                    <p><strong>メーカー:</strong> {{ $product->company->company_name }}</p>
                    
                    <!-- 価格 -->
                    <p><strong>価格:</strong> ¥{{ number_format($product->price) }}</p>
                    
                    <!-- 在庫数 -->
                    <p><strong>在庫数:</strong> {{ $product->stock }}</p>
                    
                    <!-- コメント -->
                    <p><strong>コメント:</strong><br>
                        {!! nl2br(e($product->comment)) !!}
                    </p>
                </div>
            </div>

            <div class="mt-3">
                <!-- 編集画面へのリンク（選択した商品のIDを動的にセット） -->
                <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-warning text-white">編集</a>
                <!-- 一覧画面へ戻るリンク -->
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection