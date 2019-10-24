@extends('layouts.app')

@section('title', 'カート | ECサイト')

@section('content')
<div class="container">
  <h1>カート</h1>
  <div class="base">
    @if (Auth::check())
      <p>{{ \Auth::user()->name }} さんのカート</p>
    @else
      <p>
        ゲストさんのカート
        <button class="btn btn-primary right" type="button" onclick="location.href='/auth/login'">ログイン</button>
      </p>
    @endif
    <div class="cb"></div>
  </div>
  @if (!empty($errors_over))
    <div class="base">
      @foreach ($errors_over as $error)
        <p><span class="error">{{ $error }}</span></p>
      @endforeach
    </div>
  @endif
  @if (!empty($rows))
    <table>
      <tr>
        <th>商品名</th><th>単価</th><th>購入希望数</th><th>在庫数</th><th>小計</th>
      </tr>
      @foreach ($rows as $row)
        <tr>
          <td>{{ $row->name }}</td>
          <td>{{ $row->price }}円</td>
          <td>{{ $row->num }}個</td>
          <td>{{ $row->stock }}個</td>
          <td>{{ $row->price * $row->num }}円</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="3"> </td><td><strong>合計</strong></td><td>{{ $sum }}円</td>
      </tr>
    </table>
  @else
    <div class="base">
      <p>カートの中身はありません。</p>
    </div>
  @endif
  <div class="base">
    <a class="btn btn-primary" href="/">お買い物に戻る</a>
    @if ($sum > 0)
      <a class="btn btn-primary"href="/cart/empty">カートを空にする</a>
    @endif
    @if ($sum > 0 && count($errors_over) === 0)
      <a class="btn btn-primary"href="/cart/buy">購入する</a>
    @endif
  </div>
</div>
@endsection
