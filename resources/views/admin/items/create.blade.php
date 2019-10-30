@extends('layouts.app')

@section('title', '商品追加')

@section('content')
<div class="container mt-5">
  <div class="card mx-auto" style="width: 40rem;">
    <div class="card-header">商品追加</div>
    <div class="card-body">
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <span class="error">{{ $error }}</span><br>
        @endforeach
      @endif
      <form action="create" method="post">
        @csrf
        <p>
          商品名<br>
          <input type="text" name="items_name" value="{{ old('items_name') }}">
        </p>
        <p>
          商品説明<br>
          <textarea name="comment" rows="10" cols="50">{{ old('comment') }}</textarea>
        </p>
        <p>
          価格<br>
          <input type="text" name="price" value="{{ old('price') }}">円
        </p>
        <p>
          在庫<br>
          <input type="text" name="stock" value="{{ old('stock') }}">個
        </p>
        <p>
          <input type="submit" name="submit" class="btn btn-primary" value="追加">
        </p>
      </form>
    </div>
    <div class="card-footer">
      <a class="btn btn-primary" href="./">一覧に戻る</a>
    </div>
  </div>
</div>
@endsection
