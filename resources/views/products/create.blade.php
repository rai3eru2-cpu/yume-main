@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">商品情報登録画面</h2>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="product_name" class="form-label">商品名 <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>

                <div class="mb-3">
                    <label for="company_id" class="form-label">メーカー名 <span class="text-danger">*</span></label>
                    <select class="form-select" id="company_id" name="company_id" required>
                        <option value="">メーカーを選択してください</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">在庫数 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="img_path" class="form-label">商品画像</label>
                    <input type="file" class="form-control" id="img_path" name="img_path">
                </div>

                <button type="submit" class="btn btn-primary">新規登録</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
            </form>
        </div>
    </div>
</div>
@endsection