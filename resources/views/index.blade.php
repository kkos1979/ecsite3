@extends('layouts.app')

@section('title', 'ECサイトTOP')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <p class="navbar-brand">ECサイトTOP</p>
  @if (Auth::check())
    <p style="line-height: 46px;">{{ \Auth::user()->name }}さん、こんにちは。</p>
    <div class="navbar-nav ml-auto">
      <a class="btn btn-primary" href="./auth/logout">ログアウト</a>
    </div>
  @else
    <ul class="navbar-nav ml-auto">
      <li><a class="btn btn-primary" style="margin-right: 2rem;" href="./auth/login">ログイン</a></li>
      <li><a class="btn btn-primary" href="./auth/register">新規登録</a></li>
    </ul>
  @endif
</nav>
<div class="container">
  <div class="card mt-5">
    @if ($items->isNotEmpty())
      <form action="./cart" method="post">
        {{ csrf_field() }}
        <table class="table">
          <thead class="thead-light">
            <tr><th style="width: 20%;">画像</th><th>商品名・商品説明</th><th style="width: 20%;">価格・在庫</th><th style="width: 20%;">購入数</th></tr>
          </thead>
          @foreach ($items as $g)
            <tr>
              <td>
                <img src="./images/{{ $g->image }}.jpg" alt="">
              </td>
              <td>
                <p class="items">{{ $g->name }}</p>
                <p>{{ $g->comment }}</p>
              </td>
              <td width="100">
                <p>{{ $g->price }}円</p>
                <p>在庫 {{ $g->stock }} 個</p>
              </td>
              <td>
                @if ($g->stock > 0)
                  <select name="num_{{ $g->id }}">
                    @for ($i = 0; $i <= $g->stock; $i++)
                      <option>{{ $i }}</option>
                    @endfor
                  </select>
                @else
                  <p>品切れ中</p>
                @endif
              </td>
            </tr>
          @endforeach
        </table>
        <div class="card-footer">
          <p style="display:inline-block;"> </p>
          <input class="btn btn-primary float-right" type="submit" value="カートへ">
        </div>
      </form>
    @else
      <div class="base">
        <p>現在、商品はありません。</p>
      </div>
    @endif
  </div>
</div>
<footer>
  <br>
</footer>
@endsection
