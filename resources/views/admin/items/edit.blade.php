@extends('layouts.app')

@section('title', '商品修正')

@section('content')
<div class="container mt-5">
  <div class="card mx-auto" style="width: 40rem;">
    <div class="card-header">商品の修正</div>
    <div class="card-body">
      @if ($errors->any())
        <div class="base">
          @foreach ($errors->all() as $error)
            <span class="error">{{ $error }}</span><br>
          @endforeach
        </div>
      @endif
      <form action="{{ $g->id }}" method="post">
        @csrf
        <p>
          商品名<br>
          <input type="text" name="items_name" value="{{ old('items_name') ?? $g->name }}">
        </p>
        <p>
          商品説明<br>
          <textarea name="comment" rows="10" cols="50">{{ old('comment') ?? $g->comment }}</textarea>
        </p>
        <p>
          価格<br>
          <input type="text" name="price" value="{{ old('price') ?? $g->price }}">円
        </p>
        <p>
          在庫<br>
          <input type="text" name="stock" value="{{ old('stock') ?? $g->stock }}">個
        </p>
        <p>
          <input class="btn btn-primary" type="submit" value="更新">
        </p>
      </form>
    </div>
    <div class="card-footer">
      <a class="btn btn-primary" href="../">一覧に戻る</a>
    </div>
  </div>
</div>
@endsection
