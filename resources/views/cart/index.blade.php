@extends('layouts.app')

@section('title', 'カート | ECサイト')

@section('content')
<div class="container mt-5">
  <div class="card mx-auto" style="width: 40rem;">
    <div class="card-header">
      @if (Auth::check())
        <p>{{ \Auth::user()->name }} さんのカート</p>
      @else
        <p style="display: inline-block;">ゲストさんのカート</p>
        <a class="btn btn-primary float-right" href="./auth/login">ログイン</a>
      @endif
    </div>
    @if (!empty($errors_over))
      <div class="base">
        @foreach ($errors_over as $error)
          <p><span class="error">{{ $error }}</span></p>
        @endforeach
      </div>
    @endif
    @if (!empty($rows))
      <table class="table">
        <thead class="thead-light">
        <tr>
          <th>商品名</th><th>単価</th><th>購入希望数</th><th>在庫数</th><th>小計</th>
        </tr>
        </thead>
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
      <p class="ml-4 mt-3 mb-3">カートの中身はありません。</p>
    @endif
    <div class="card-footer">
      <a class="btn btn-primary" href="./">お買い物に戻る</a>
      @if ($sum > 0)
        <a class="btn btn-primary"href="./cart/empty">カートを空にする</a>
      @endif
      @if ($sum > 0 && count($errors_over) === 0)
        <a class="btn btn-primary right"href="./cart/buy">購入する</a>
      @endif
    </div>
  </div>
</div>
@endsection
