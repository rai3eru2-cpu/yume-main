@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">商品情報一覧画面</h2>

            <!-- 検索フォーム -->
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="商品名（部分一致）" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="company_id" class="form-select">
                            <option value="">メーカー名を選択</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">検索</button>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('products.create') }}" class="btn btn-success w-100">新規登録</a>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- 商品一覧テーブル -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <!-- ID -->
                            <td>{{ $product->id }}</td>
                            
                            <!-- 商品画像（登録がある場合のみ表示） -->
                            <td>
                                @if($product->img_path)
                                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" style="width: 50px; height: auto;">
                                @else
                                    <span class="text-muted">画像なし</span>
                                @endif
                            </td>
                            
                            <!-- 商品名 -->
                            <td>{{ $product->product_name }}</td>
                            
                            <!-- 価格 -->
                            <td>¥{{ number_format($product->price) }}</td>
                            
                            <!-- 在庫数 -->
                            <td>{{ $product->stock }}</td>
                            
                            <!-- メーカー名（会社テーブルと紐づいた名前を表示） -->
                            <td>{{ $product->company->company_name }}</td>
                            
                            <!-- 操作ボタン -->
                            <td>
                                <a href="{{ route('products.show', ['id' => $product->id]) }}" class="btn btn-info btn-sm text-white">詳細</a>
                                
                                <!-- ⚠️ 仕様書ルール：削除時は確認ダイアログ（onsubmit）を挟むこと -->
                                <form action="{{ route('products.destroy', ['id' => $product->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">登録されている商品がありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection