@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">商品情報編集画面</h2>

            @if (session('success'))
                <div class="alert alert-success fw-bold mb-4 text-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="product_name" class="form-label">商品名 <span class="text-danger">*</span></label>
                    <!-- old() の第2引数に既存のデータを指定して、エラー時のみ入力値を残す設計（指摘2） -->
                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                    @error('product_name')
                        <div class="invalid-feedback fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="company_id" class="form-label">メーカー名 <span class="text-danger">*</span></label>
                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id" required>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <div class="invalid-feedback fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">在庫数 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                        <div class="invalid-feedback fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">コメント</label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3">{{ old('comment', $product->comment) }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="img_path" class="form-label">商品画像</label>
                    @if($product->img_path)
                        <div class="mb-2">
                            <!-- インラインCSS(style)を完全削除し、Bootstrapのレスポンシブクラスへ移行（指摘5） -->
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="現在の画像" class="img-thumbnail img-fluid">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('img_path') is-invalid @enderror" id="img_path" name="img_path">
                    @error('img_path')
                        <div class="invalid-feedback fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('products.show', ['id' => $product->id]) }}" class="btn btn-secondary">戻る</a>
            </form>
        </div>
    </div>
</div>
@endsection