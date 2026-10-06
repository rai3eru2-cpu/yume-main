@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">商品情報編集画面</h2>

            <!--  対象商品のIDをルートに動的に引き渡す設定に変更 -->
            <form action="{{ route('products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="product_name" class="form-label">商品名 <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                </div>

                <div class="mb-3">
                    <label for="company_id" class="form-label">メーカー名 <span class="text-danger">*</span></label>
                    <select class="form-select" id="company_id" name="company_id" required>
                        @foreach($companies as $company)
                            <!--  登録されているメーカーに自動でチェック（selected）が入る設定 -->
                            <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">在庫数 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3">{{ $product->comment }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="img_path" class="form-label">商品画像</label>
                    @if($product->img_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="現在の画像" style="width: 100px; height: auto;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="img_path" name="img_path">
                </div>

                <button type="submit" class="btn btn-primary">更新</button>
                <!-- 戻るボタンも対象商品の詳細画面（show）へ動的に戻るように変更 -->
                <a href="{{ route('products.show', ['id' => $product->id]) }}" class="btn btn-secondary">戻る</a>
            </form>
        </div>
    </div>
</div>
@endsection